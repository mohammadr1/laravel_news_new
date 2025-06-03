<?php

namespace App\Filament\Resources\DailyMediaResource\Pages;

use App\Filament\Resources\DailyMediaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDailyMedia extends CreateRecord
{
    protected static string $resource = DailyMediaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // اگر نوع رسانه تصویر باشد، مقدار image_upload را در media_path ذخیره کن
        if ($data['media_type'] === 'image' && isset($data['image_upload'])) {
            $data['media_path'] = $data['image_upload'];
        }

        // اگر نوع رسانه ویدیو باشد، مقدار video_link را در media_path ذخیره کن
        if ($data['media_type'] === 'video' && isset($data['video_link'])) {
            $data['media_path'] = $data['video_link'];
        }

        // فیلدهای اضافی را حذف کنیم
        unset($data['image_upload'], $data['video_link']);

        return $data;
    }

}
