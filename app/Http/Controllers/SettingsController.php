<?php

namespace App\Http\Controllers;

use App\Option;
use App\SurveyQuestion;
use Illuminate\Http\Request;
use App\Course;
use Excel;
use App\Imports\UsersImport;
use App\Review;
use App\User;
use App\UserPayment;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DateTime;
use App\Province;
use App\BlastingSettings;
use App\TextSettings;
use App\PaymentAds;


class SettingsController extends Controller
{


    public function GeneralSettings()
    {
        $title = trans('admin.general_settings');
        return view('admin.settings.general_settings', compact('title'));
    }

    public function LMSSettings()
    {
        $title = trans('admin.lms_settings');
        return view('admin.settings.lms_settings', compact('title'));
    }

    public function StorageSettings()
    {
        $title = trans('admin.file_storage_settings');
        return view('admin.settings.storage_settings', compact('title'));
    }

    public function SurveySettings()
    {
        $data['title'] = 'Survey Question';
        $data['surveys'] = SurveyQuestion::orderBy('created_at', 'asc')->paginate(10);

        return view('admin.settings.survey_settings', $data);
    }

    public function SurveyCreate()
    {
        $data['title'] = 'Survey Question';
        $data['sub_title'] = 'Survey Question Create';

        return view('admin.settings.survey_add', $data);
    }

    public function SurveyStore(Request $request)
    {
        SurveyQuestion::create([
            'question'  => $request->question,
            'type'      => $request->type,
            'answer'    => $request->answer,
            'publish'   => $request->publish,
        ]);
        return redirect()->route('survey_settings');
    }

    public function SurveyEdit($id)
    {
        $data['title'] = 'Survey Question';
        $data['sub_title'] = 'Survey Question Edit';
        $data['survey'] = SurveyQuestion::where('id', $id)->first();

        return view('admin.settings.survey_edit', $data);
    }

    public function SurveyUpdate(Request $request, $id)
    {
        SurveyQuestion::where('id', $id)->update([
            'question'  => $request->question,
            'type'      => $request->type,
            'answer'    => $request->answer,
            'publish'   => $request->publish,
        ]);

        return redirect()->route('survey_settings');
    }

    public function SurveyDelete($id)
    {
        SurveyQuestion::where('id', $id)->delete();

        return redirect()->route('survey_settings');
    }

    public function SurveyPublish(Request $request)
    {
        $category = SurveyQuestion::where('id', $request->id)->update([
            'publish'   => $request->publish
        ]);
        return 1;
    }

    public function KomisiSettings()
    {
        $data['title'] = 'Komisi Setting';

        return view('admin.settings.komisi_settings', $data);
    }

    public function KomisiUpdate(Request $request)
    {
        Option::where('option_key', $request->option_key)->update([
            'option_value' => $request->option_value
        ]);
        return redirect()->route('komisi_settings');
    }

    public function ThemeSettings()
    {
        $title = trans('admin.theme_settings');
        return view('admin.settings.theme_settings', compact('title'));
    }
    public function invoiceSettings()
    {
        $title = trans('admin.invoice_settings');
        return view('admin.settings.invoice_settings', compact('title'));
    }

    public function modernThemeSettings()
    {
        $title = trans('admin.modern_theme_settings');
        return view('admin.settings.modern_theme_settings', compact('title'));
    }

    public function SocialUrlSettings()
    {
        $title = trans('admin.social_url_settings');
        return view('admin.settings.social_url_settings', compact('title'));
    }
    public function SocialSettings()
    {
        $title = __a('social_login_settings');
        return view('admin.settings.social_settings', compact('title'));
    }
    public function BlogSettings()
    {
        $title = trans('admin.blog_settings');
        return view('admin.settings.blog_settings', compact('title'));
    }

    public function withdraw()
    {
        $title = trans('admin.withdraw');
        return view('admin.settings.withdraw_settings', compact('title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */

    public function update(Request $request)
    {
        $inputs = array_except($request->input(), ['_token']);

        foreach ($inputs as $key => $value) {
            if (is_array($value)) {
                $value = 'json_encode_value_' . json_encode($value);
            }

            $option = Option::firstOrCreate(['option_key' => $key]);
            $option->option_value = $value;
            $option->save();
        }
        //check is request comes via ajax?
        if ($request->ajax()) {
            return ['success' => 1, 'msg' => __a('settings_saved_msg')];
        }
        return redirect()->back()->with('success', __a('settings_saved_msg'));
    }
    public function LinkSettings(Request $request)
    {
        $title = trans('Settings Link');
        $province = Province::get('*')->whereNotNull('provinsi');

        return view('admin.settings.link_settings', compact('title', 'province'));
    }
    public function blastingSettings(Request $request)
    {
        $title = trans('Settings Blasting');
        $province = BlastingSettings::get('*')->whereNotNull('nomor');

        return view('admin.settings.blasting_settings', compact('title', 'province'));
    }
    public function textSettings(Request $request)
    {
        $title = trans('Settings Blasting');
        $province = TextSettings::get('*')->whereNotNull('title');

        return view('admin.settings.text_setting', compact('title', 'province'));
    }
    public function editLink(Request $request, $id)
    {
        Province::where('id', $id)->update([
            'link'  => $request->link,
        ]);

        return redirect()->route('link_wa')->with('success', "Link WhatsApp updated!");
    }
    public function editBlasting(Request $request, $id)
    {
        BlastingSettings::where('id', $id)->update([
            'nomor'  => $request->nomor,
            'instance_id'  => $request->instance_id,
        ]);

        return redirect()->route('blasting_settings')->with('success', "Nomor Blasting Updated!");
    }

    public function AddNomorBlasting()
    {
        $data['title'] = 'Nomor Blasting';
        $data['sub_title'] = 'Nomor Blasting Create';

        return view('admin.settings.blasting_add', $data);
    }
    public function AddTextBlasting()
    {
        $data['title'] = 'Text Blasting';
        $data['sub_title'] = 'Text Blasting Create';

        return view('admin.settings.text_add', $data);
    }
    public function TextBlastingStore(Request $request)
    {
        TextSettings::create([
            'title'     => $request->title,
            'text'      => $request->text_blast,
            'label'     => $request->label,
            'instance_id' => $request->instance_id
        ]);
        return redirect()->route('text_settings');
    }
    public function editText(Request $request, $id)
    {
        TextSettings::where('id', $id)->update([
            'title'     => $request->title,
            'text'      => $request->text_blast,
            'label'     =>$request->label,
            'instance_id' => $request->instance_id
        ]);

        return redirect()->route('text_settings')->with('success', "Text Blasting Updated!");
    }

    public function NomorBlastingStore(Request $request)
    {
        BlastingSettings::create([
            'nomor'            => $request->nomor_hp,
            'instance_id'      => $request->instance_id,
        ]);
        return redirect()->route('blasting_settings');
    }
    
}
