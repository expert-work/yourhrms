<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Settings\HrmLanguage;
use App\Repositories\Settings\CompanyConfigRepository;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class HrmLanguageRepository.
 */
class HrmLanguageRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    // protected $company_config;
    // public function __construct(CompanyConfigRepository $company_config)
    // {
    //     $this->company_config = $company_config;
    // }
    public function model()
    {
        return HrmLanguage::class;
    }

    public function dataTable()
    {
        $hrm_languages = $this->model->get();
        // return $hrm_languages;
        return datatables()->of($hrm_languages)
            ->addColumn('action', function ($data) {

                $action_button = '';
                $setup = _trans('settings.Setup');
                $makeDefault = _trans('settings.Make Default');
                $delete = _trans('common.Delete');

                // if (hasPermission('leave_assign_update')) {
                    $action_button .= '<a href="' . route('language.setup',$data->language->id) . '" class="dropdown-item"> '.$setup.'</a>';
                    // }
                if ($data->is_default == 0) {
                    $action_button .= '<a href="' . route('language.makeDefault',$data->language->id) . '" class="dropdown-item">'.$makeDefault.'</a>';
                }
                if ($data->is_default == 0) {
                    $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`admin/settings/language-setup/delete/`)', 'delete');
                }
                $button = '<div class="flex-nowrap">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle align-text-top action-dot-btn" data-boundary="viewport" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">' . $action_button . '</div>
                    </div>
                </div>';
                return $button;
            })
            ->addColumn('code', function ($data) {
                return $data->language->code;
            })
            ->addColumn('name', function ($data) {
                $default=$data->is_default==1?'<span class="badge badge-success">Default</span>':'';
                return $data->language->name . ' ' . $default;
            })
            ->addColumn('native', function ($data) {
                return $data->language->native;
            })
            ->addColumn('rtl', function ($data) {
                return $data->language->IsRtl;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })

            ->rawColumns(array('action', 'code', 'name', 'native', 'rtl','status'))
            ->make(true);
    }

    public function pluckData($data){
        return $this->model->pluck($data);
    }
    public function makeDefault($id){
       try{

        DB::beginTransaction();

        $this->model->wherein('is_default',[1])->update(array('is_default' => 0));

        $language = $this->model->where('language_id',$id)->first();
        $language->is_default = 1;
        $language->save();


        CompanyConfigRepository::setupConfig('lang',$language->language->code);

        if (auth()->user()->role_id==1) {
            putEnvConfigration('APP_LOCAL',$language->language->code);
        }

        DB::commit();
        return true;
       }catch(Exception $e){
        DB::rollBack();
            return false;
       }
    }

    public static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public function deleteLang($id){
       try{

        DB::beginTransaction();

        $check_default=  $this->model->find($id);
        if ($check_default->is_default==1) {
            return false;
        }
        $folder = resource_path('lang/' . $check_default->language->code . '/');
        if (file_exists($folder)) {
            $this->deleteDir($folder);
        }
        $check_default->delete();

        DB::commit();
        return true;
       }catch(Exception $e){
        DB::rollBack();
            return false;
       }
    }

   
}
