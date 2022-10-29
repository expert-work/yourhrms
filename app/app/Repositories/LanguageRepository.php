<?php

namespace App\Repositories;

use App\Models\Settings\Language;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class LanguageRepository.
 */
class LanguageRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Language::class;
    }
    
    public function setUserLang($request)
    {
        try {
            $user = auth()->user();
            $user->lang = $request->lang;
            $user->save();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
