<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformationFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return  true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'vehicleRegistrationCertificateImages' => 'required|array|max:20',
            'vehicleRegistrationCertificateImages.*' => 'mimes:jpeg,png,jpg,pdf|max:2048',
            'driverLicenseImages' => 'required|array|max:20',
            'driverLicenseImages.*' => 'mimes:jpeg,png,jpg,pdf|max:2048',
            'insuranceImages.*' => 'mimes:jpeg,png,jpg,pdf|max:2048',
            'damageImages' => 'required|array|max:20',
            'damageImages.*' => 'mimes:jpeg,png,jpg,pdf|max:2048',
            'policeReportImages.*' => 'mimes:jpeg,png,jpg,pdf|max:2048',
            'trafficInsuranceImages.*' => 'mimes:jpeg,png,jpg,pdf|max:2048',
            'accidentReportImages.*' => 'mimes:jpeg,png,jpg,pdf|max:2048',

        ];
    }
}
