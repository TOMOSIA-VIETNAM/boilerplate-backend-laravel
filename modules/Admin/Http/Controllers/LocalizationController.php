<?php

namespace Modules\Admin\Http\Controllers;

use App\Enums\LangEnum;
use Illuminate\Http\RedirectResponse;

class LocalizationController extends AdminController
{
    /**
     * @param $locale
     * @return RedirectResponse
     */
    public function index($locale)
    {
        abort_if(is_bool(array_search($locale, array_column(LangEnum::ALLOW_LOCALES, 'code'))), 404);

        app()->setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }
}
