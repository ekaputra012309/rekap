<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class HomeController extends Controller
{
    public function editProfile()
    {
        $data = array(
            'title' => 'Profile',
        );
        return view('auth.profile', $data);
    }

    public function editCompany()
    {
        $company = Company::first();
        $data = array(
            'title' => 'Perusahaan',
            'company' => $company,
        );
        return view('auth.company', $data);
    }

    public function updateCompany(Request $request, Company $company)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($company->logo && \Storage::disk('public')->exists($company->logo)) {
                \Storage::disk('public')->delete($company->logo);
            }

            // Generate unique filename
            $originalExt = $request->file('logo')->getClientOriginalExtension();
            $filename = 'logo_' . time() . '_' . uniqid() . '.' . $originalExt;

            // Store in public/img folder
            $data['logo'] = $request->file('logo')->storeAs('img', $filename, 'public');
        }

        $company->update($data);

        // return redirect()->route('company.edit', $company->id)->with('success', 'Company updated successfully.');
        return redirect('/company')->with('toast', [
            'type' => 'success', 
            'message' => 'Company updated  successfully.',
        ]);
    }


}
