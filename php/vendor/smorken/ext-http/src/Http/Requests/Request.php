<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 6/16/16
 * Time: 10:48 AM
 */

namespace Smorken\Ext\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Smorken\Sanitizer\Contracts\Sanitize;

abstract class Request extends FormRequest
{

    public function authorize()
    {
        return true;
    }

//    public function rules(Sanitize $s, ProviderContract $provider)
//    {
//        return $this->sanitizeAndGetRules($s, $provider);
//    }
//      OR
//    public function validator(Sanitize $s, ProviderContract $provider, $validation_factory)
//    {
//        $this->sanitize($s);
//        return $validation_factory->make(
//          $this->all(),
//          $provider->getModel()->rules(),
//          $this->messages(),
//          $this->attributes()
//      );
//    }

    /**
     * @param Sanitize $s
     * @param $provider
     * @return array|null
     */
    protected function sanitizeAndGetRules(Sanitize $s, $provider)
    {
        $this->sanitize($s);
        return $provider->getModel()->rules();
    }

    /**
     * @param Sanitize $sanitize
     */
    public function sanitize(Sanitize $sanitize)
    {
        $input = $this->all();
        $this->replace($this->doSanitize($input, $sanitize));
    }

    /**
     * @param array $input
     * @param Sanitize $s
     * @return array
     */
    protected function doSanitize($input, Sanitize $s)
    {
        return $input;
    }
}
