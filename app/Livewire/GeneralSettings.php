<?php

namespace App\Livewire;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class GeneralSettings extends Component
{
    use WithFileUploads;

    public $company_name;
    public $company_phone;
    public $company_tel;
    public $company_email;
    public $company_url;
    public $company_address;
    public $currency = '$';
    public $language = 'English';
    public $min_withdrawal;
    public $withdrawal_fee_type;
    public $withdrawal_fee;
    public $white_logo;
    public $dark_logo;
    public $favicon;

    public $white_logo_preview;
    public $dark_logo_preview;
    public $favicon_preview;


    public function UpdateCompanySettings()
    {
        $valid = $this->validate([
            'company_name' => 'required|string|max:255',
            'company_phone' => 'required|string|max:255',
            'company_tel' => 'nullable|string|max:255',
            'company_email' => 'required|email|max:255',
            'company_url' => 'nullable|url|max:255',
            'company_address' => 'nullable|string|max:255',
            'currency' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'min_withdrawal' => 'required|integer|',
            'withdrawal_fee_type' => 'required|string|max:255',
            'withdrawal_fee' => 'required|numeric|',
            'white_logo' => 'nullable|image:png,jpg,jpeg|max:5000',
            'dark_logo' => 'nullable|image:png,jpg,jpeg|max:5000',
            'favicon' => 'nullable|image:png,jpg,jpeg|max:5000',
        ]);

        if ($valid) {
            $settings = Setting::updateOrCreate(
                ['status' => true],
                [
                    'company_name' => $this->company_name,
                    'company_phone' => $this->company_phone,
                    'company_tel' => $this->company_tel,
                    'company_email' => $this->company_email,
                    'company_url' => $this->company_url,
                    'company_address' => $this->company_address,
                    'currency' => $this->currency,
                    'language' => $this->language,
                    'min_withdrawal' => $this->min_withdrawal,
                    'withdrawal_fee_type' => $this->withdrawal_fee_type,
                    'withdrawal_fee' => $this->withdrawal_fee,
                ]
            );


            // Upload White Logo
            if ($this->white_logo) {

                // Delete Old Image if Exist
                $this->DeletePreviousImage(($settings->white_logo));

                $image_name = time() . $this->white_logo->getClientOriginalName();
                Setting::find($settings->id)->update([
                    'white_logo' => $image_name,
                ]);

                // Upload Image to Local Disk
                $this->UploadNewImage($this->white_logo, $image_name);
            }
            // Upload Dark Logo
            if ($this->dark_logo) {

                // Delete Old Image if Exist
                $this->DeletePreviousImage(($settings->dark_logo));

                $image_name = time() . $this->dark_logo->getClientOriginalName();
                Setting::find($settings->id)->update([
                    'dark_logo' => $image_name,
                ]);

                // Upload Image to Local Disk
                $this->UploadNewImage($this->dark_logo, $image_name);
            }
            // Upload Favicon
            if ($this->favicon) {

                // Delete Old Image if Exist
                $this->DeletePreviousImage(($settings->favicon));

                $image_name = time() . $this->favicon->getClientOriginalName();
                Setting::find($settings->id)->update([
                    'favicon' => $image_name,
                ]);

                // Upload Image to Local Disk
                $this->UploadNewImage($this->favicon, $image_name);
            }
        }

        if ($settings) {
            // Dispatch Success Message
            $this->dispatch('showToast', ['status' => true, 'message' => 'Updated Successfully.']);

            // Reset Variables
            $this->reset(['white_logo', 'dark_logo', 'favicon',]);

            // Get Settings Values
            $this->GetSettings();
        }
    }

    // Upload New Image
    public function UploadNewImage($image, $name)
    {
        $image->storeAs('public/settings/', $name);
    }

    // Delete Previous Image
    public function DeletePreviousImage($name)
    {
        Storage::delete('public/settings/' . $name);
    }

    // Get Settings Values
    public function GetSettings()
    {
        $settings = Setting::where('status', 1)->first();

        if ($settings) {
            $this->company_name = $settings->company_name;
            $this->company_phone = $settings->company_phone;
            $this->company_tel = $settings->company_tel;
            $this->company_email = $settings->company_email;
            $this->company_url = $settings->company_url;
            $this->company_address = $settings->company_address;
            $this->currency = $settings->currency;
            $this->language = $settings->language;
            $this->min_withdrawal = $settings->min_withdrawal;
            $this->withdrawal_fee_type = $settings->withdrawal_fee_type;
            $this->withdrawal_fee = $settings->withdrawal_fee;
            $this->white_logo_preview = $settings->white_logo;
            $this->dark_logo_preview = $settings->dark_logo;
            $this->favicon_preview = $settings->favicon;
        }
    }

    public function mount()
    {
        $this->GetSettings();
    }

    public function render()
    {
        return view('livewire.general-settings');
    }
}
