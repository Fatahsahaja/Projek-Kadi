<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidIndonesianPhone implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Format yang diterima: 08xxx atau +62xxx atau 628xxx
        $pattern = '/^(\+62|62|0)[0-9]{9,12}$/';
        
        if (!preg_match($pattern, $value)) {
            $fail('Nomor telepon harus format Indonesia yang valid (contoh: 081234567890 atau +6281234567890)');
        }

        // Validasi operator Indonesia (opsional)
        $validPrefixes = ['0811', '0812', '0813', '0821', '0822', '0823', '0851', '0852', '0853', '0855', '0856', '0857', '0858', '0895', '0896', '0897', '0898', '0899'];
        
        $prefix = substr(str_replace(['+62', '62'], '0', $value), 0, 4);
        
        if (!in_array($prefix, $validPrefixes)) {
            $fail('Nomor telepon harus menggunakan operator Indonesia yang valid (Telkomsel, Indosat, XL, Tri, Smartfren)');
        }
    }
}