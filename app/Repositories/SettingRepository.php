<?php


namespace App\Repositories;
use App\Models\GlobalSetting;

class SettingRepository extends BaseRepository
{

    /**
     * @var GlobalSetting
     */
    protected  $model;

    /**
     * SettingRepository constructor.
     * @param GlobalSetting $globalSetting
     */
    public function __construct(GlobalSetting $globalSetting)
    {
        $this->model = $globalSetting;

    }

    /**
     * @param string $key
     * @return Model|null
     */
    public function findByKey(string $key) :?Model
    {
        return $this->model->where('key',$key)->first();
    }
}
