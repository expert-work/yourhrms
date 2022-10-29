<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ImageUpload extends Component
{
     /**
     * Create a new component instance.
     *
     * @return void
     */
    public $fileType;
    public $label;
    public $name;
    public $preview;
    public function __construct($fileType, $label ,$name,$preview)
    {
        $this->fileType = $fileType;
        $this->label = $label;
        $this->name = $name;
        $this->preview = $preview;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $data['accepted_file_types'] = $this->fileExtension($this->fileType);
        $data['random_number'] = rand(1, 100000);
        $data['preview'] = $this->preview=="true"?'block':'none';

        return view('components.image-upload',compact('data'));
    }

    public function fileExtension($fileType)
    {
        switch ($fileType) {
            case 'image':
                return '.jpg,.jpeg,.png,.gif';
                break;
            
            default:
                return null;
                break;
        }
    }
}
