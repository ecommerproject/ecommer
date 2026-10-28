<?php

namespace App\Services;

class BakongKhqrService
{
    /**
     * Generate an NBC KHQR compliant EMV string.
     *
     * @param string $bakongId   e.g. "dara_market@abaa" or "012345678@abaa"
     * @param string $merchantName e.g. "DARA MARKET"
     * @param string $merchantCity e.g. "Phnom Penh"
     * @param float  $amount       e.g. 28.00
     * @param string $currency     "USD" or "KHR"
     * @param string $billNumber   e.g. "ORD-2026-1050"
     * @param string|null $mobileNumber optional mobile number
     * @return string EMVCo formatted KHQR payload
     */
    public static function generateKhqr(
        string $bakongId,
        string $merchantName = 'DARA MARKET',
        string $merchantCity = 'Phnom Penh',
        float $amount = 0.0,
        string $currency = 'USD',
        string $billNumber = '',
        ?string $mobileNumber = null
    ): string {
        $cleanBakongId = trim($bakongId ?: 'dara_market@abaa');
        $cleanMerchantName = strtoupper(substr(preg_replace('/[^a-zA-Z0-9 ]/', '', $merchantName ?: 'DARA MARKET'), 0, 25));
        $cleanCity = substr(preg_replace('/[^a-zA-Z0-9 ]/', '', $merchantCity ?: 'Phnom Penh'), 0, 15);
        $currencyCode = strtoupper($currency) === 'KHR' ? '116' : '840';

        // Merchant Account Information (Tag 29)
        // Sub-tag 00: Bakong Account Identifier
        $subTag00 = self::formatTlv('00', $cleanBakongId);
        $tag29Value = $subTag00;
        if (!empty($cleanMerchantName)) {
            $tag29Value .= self::formatTlv('01', $cleanMerchantName);
        }

        // Additional Data Field (Tag 62)
        $tag62Value = '';
        if (!empty($billNumber)) {
            $tag62Value .= self::formatTlv('01', substr($billNumber, 0, 25)); // Bill Number
        }
        if (!empty($mobileNumber)) {
            $tag62Value .= self::formatTlv('02', substr($mobileNumber, 0, 25)); // Mobile Number
        }
        if (empty($tag62Value)) {
            $tag62Value = self::formatTlv('07', 'DaraStore');
        }

        // Build Payload without CRC
        $payload = '';
        $payload .= self::formatTlv('00', '01'); // Payload Format Indicator
        $payload .= self::formatTlv('01', $amount > 0 ? '12' : '11'); // Point of Initiation (12 = dynamic with amount)
        $payload .= self::formatTlv('29', $tag29Value); // Merchant Account Information
        $payload .= self::formatTlv('52', '5999'); // Merchant Category Code (General)
        $payload .= self::formatTlv('53', $currencyCode); // Transaction Currency

        if ($amount > 0) {
            $payload .= self::formatTlv('54', number_format($amount, 2, '.', '')); // Amount
        }

        $payload .= self::formatTlv('58', 'KH'); // Country Code
        $payload .= self::formatTlv('59', $cleanMerchantName ?: 'DARA MARKET'); // Merchant Name
        $payload .= self::formatTlv('60', $cleanCity ?: 'Phnom Penh'); // Merchant City
        $payload .= self::formatTlv('62', $tag62Value); // Additional Data Field

        // Append Tag 63 with length 04 for CRC calculation
        $payloadForCrc = $payload . '6304';
        $crc = self::calculateCrc16($payloadForCrc);

        return $payloadForCrc . $crc;
    }

    /**
     * Format a Tag-Length-Value (TLV) segment.
     */
    private static function formatTlv(string $tag, string $value): string
    {
        $len = strlen($value);
        return sprintf('%02d%02d%s', (int) $tag, $len, $value);
    }

    /**
     * Compute CRC16-CCITT (0xFFFF initial value, 0x1021 polynomial).
     */
    private static function calculateCrc16(string $data): string
    {
        $crc = 0xFFFF;
        $len = strlen($data);

        for ($i = 0; $i < $len; $i++) {
            $crc ^= (ord($data[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                if ($crc & 0x8000) {
                    $crc = (($crc << 1) ^ 0x1021) & 0xFFFF;
                } else {
                    $crc = ($crc << 1) & 0xFFFF;
                }
            }
        }

        return strtoupper(sprintf('%04X', $crc));
    }

    /**
     * Return QR code image URL for displaying the KHQR code
     */
    public static function getQrImageUrl(string $khqrPayload, int $size = 320): string
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?size=' . $size . 'x' . $size . '&margin=8&data=' . urlencode($khqrPayload);
    }
}
