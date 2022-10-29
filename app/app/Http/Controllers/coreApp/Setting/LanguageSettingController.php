<?php

namespace App\Http\Controllers\coreApp\Setting;

use Illuminate\Http\Request;
use App\Models\Settings\Language;
use App\Http\Controllers\Controller;
use App\Models\Settings\HrmLanguage;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use App\Repositories\LanguageRepository;
use App\Repositories\HrmLanguageRepository;

class LanguageSettingController extends Controller
{
    private $languate;
    private $hrm_languate;
    public function __construct(LanguageRepository $language, HrmLanguageRepository $hrm_languate)
    {
        $this->language = $language;
        $this->hrm_languate = $hrm_languate;
    }

    public function language()
    {
        $data['title']='Languages';
        $data['languages'] = Cache::rememberForever('languages', function(){
            return $this->language->get();
        });
        $pluck_columns='language_id';
        $data['hrm_languages']=$this->hrm_languate->pluckData($pluck_columns)->toArray();
        return view('backend.language.index',compact('data'));
    }

    public function dataTable()
    {
        return $this->hrm_languate->dataTable();
    }

    public function setup($language){
        $selected_language=$this->language->getById($language);
        $local= $selected_language->code;
        $langPath = resource_path('lang/'.$local.'/');

        if (!file_exists($langPath)) {
            mkdir($langPath,0777,true);

            foreach (scandir(base_path('resources/lang/default/')) as $key => $value) {
                if($value!='.' && $value!='..'){
                    $file1 = base_path('resources/lang/default/' . $value);
                    if (!file_exists(base_path('resources/lang/' . $selected_language->code . '/' . $value))) {
                        copy($file1, base_path('resources/lang/' . $selected_language->code . '/' . $value));
                    }
                }
            }
        }

        $data['title']=$selected_language->name.' Language Setup';
        $data['language']=$selected_language;

        return view('backend.language.setup',compact('data'));
    }

    public function get_translate_file(Request $request)
    {
        try {
            $language = $this->language->getById($request->id);

            $file_name = explode('.', $request->file_name);
            $languages = Lang::get($file_name[0]);
            $translatable_file_name = $request->file_name;

            if (file_exists(base_path('resources/lang/' . $language->code . '/' . $request->file_name))) {
                $url = base_path('resources/lang/' . $language->code . '/' . $request->file_name);
                $languages = json_decode(file_get_contents($url), true);

                $new_data=[];
                $new_data['languages']=$languages;
                $new_data['language']=$language;
                $new_data['translatable_file_name']=$translatable_file_name;
                // return $new_data;

                return view('backend.language.translate_modal', [
                    "languages" => $languages,
                    "language" => $language,
                    "translatable_file_name" => $translatable_file_name
                ]);
            }


            $file1 = base_path('resources/lang/default/' . $request->file_name);
            if (!file_exists(base_path('resources/lang/' . $language->code))) {
                mkdir(base_path('resources/lang/' . $language->code));
            }
            if (!file_exists(base_path('resources/lang/' . $language->code . '/' . $request->file_name))) {
                copy($file1, base_path('resources/lang/' . $language->code . '/' . $request->file_name));
            }


            $file2 = base_path('resources/lang/' . $language->code . '/' . $request->file_name);
            // Count the number of lines on file
            $no_of_lines_file_1 = count(file($file1));
            $no_of_lines_file_2 = count(file($file2));

            if ($no_of_lines_file_1 > $no_of_lines_file_2) {
                $file_contents = file_get_contents($file2);
                $file_contents = str_replace("\n];", " ", $file_contents);
                file_put_contents($file2, $file_contents);
                $i = $no_of_lines_file_2 - 1;
                $lines = file($file1);
                foreach ($lines as $line) {
                    $fp = fopen($file2, 'a');
                    if ($i < $no_of_lines_file_1) {
                        fwrite($fp, $lines[$i]);
                        $i++;
                    }
                    fclose($fp);
                }
            }
            return view('backend.language.translate_modal', [
                "languages" => $languages,
                "language" => $language,
                "translatable_file_name" => $translatable_file_name
            ]);
        } catch (\Exception $e) {
            Toastr::error('Something went wrong','Error');
            return back();
        }

    }

    public function updateLangTerm(Request $request)
    {
        // $validate_rules = [
        //     'id' => 'required',
        //     'translatable_file_name' => 'required',
        //     'key' => 'required',
        // ];


        try {
            $language = $this->language->getById($request->id);

            $file_name = $request->translatable_file_name;

            $check_module = explode('::', $file_name);

            if (count($check_module) > 1) {
                $translatable_file_name = $check_module[1];
                $folder = module_path(ucfirst($check_module[0])) . '/Resources/lang/' . $language->code . '/';
            } else {
                $translatable_file_name = $request->translatable_file_name;
                $folder = resource_path('lang/' . $language->code . '/');
            }

            $file = $folder . $translatable_file_name;

            if (!file_exists($folder)) {
                mkdir($folder);
            }
            if (file_exists($file)) {
                file_put_contents($file, '');
            }
            $json_data= json_encode($request->key);
            file_put_contents($file, $json_data, true);
            Artisan::call('cache:clear');
            Toastr::success('Operation Successfully done','Success');
            return back();

        } catch (\Exception $e) {
            Toastr::error('Something went wrong','Error');
            return back();
        }
    }

    public function store(Request $request)
    {
        //validation check
        $request->validate([
            'language_id' => 'required',
        ]);

       try {
            $request=$request->except('_token');
            $this->hrm_languate->create($request);
            Toastr::success('Operation Successfully done','Success');
            return back();
       } catch (\Throwable $th) {
        Toastr::error('Something went wrong','Error');
        return back();
       }
    }
    public function makeDefault($language_id){
      try {
           $result= $this->hrm_languate->makeDefault($language_id);
           if ($result) {
                Toastr::success('Operation Successfully done','Success');
                return back();
           } else {
                Toastr::error('Operation Failed');
                return back();
           }
      } catch (\Throwable $th) {
            Toastr::error('Something went wrong','Error');
            return back();
      }
    }
    public function deleteLang ($language_id){
      try {
           $result= $this->hrm_languate->deleteLang ($language_id);
           if ($result) {
                Toastr::success('Operation Successfully done','Success');
                return back();
           } else {
                Toastr::error('Operation Failed');
                return back();
           }
      } catch (\Throwable $th) {
            Toastr::error('Something went wrong','Error');
            return back();
      }
    }

    public function ajaxLangChange(Request $request)
    {
        try {
            $result = $this->language->setUserLang($request);
            return response()->json([
                'success' => true,
                'message' => 'Language Changed Successfully',
                'result' => $result
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'result' => null
            ]);
        }
    }
}
