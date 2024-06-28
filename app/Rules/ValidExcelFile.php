<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class ValidExcelFile implements Rule
{
    public function passes($attribute, $value)
    {
        if (!$value instanceof UploadedFile) {
            return false;
        }

        $extension = $value->getClientOriginalExtension();

        return in_array($extension, ['xls', 'xlsx']);
    }

    public function message()
    {
        return 'The uploaded file must be a valid Excel file.';
    }
}
