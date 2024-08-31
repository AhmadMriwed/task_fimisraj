<?php

namespace App\Models\Media;

use App\Models\MailBox\ReplayBox;
use App\Models\MailBox\ReplayBoxFile;
use App\Models\MailBox\RequestBox;
use App\Models\MailBox\RequestBoxFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;
    protected $fillable = [
      'name',
      'path',
      'size',
      'type',
      'sub_type',
  ];
    public function replayBoxes()
{
  return $this->belongsToMany(ReplayBox::class, ReplayBoxFile::class, 'files_id', 'replay_boxes_id')
      ->withTimestamps(); // If you want to automatically manage created_at and updated_at timestamps
}

public function requestBoxes()
  {
      return $this->belongsToMany(RequestBox::class, RequestBoxFile::class, 'files_id', 'request_boxes_id')
          ->withTimestamps(); // If you want to automatically manage created_at and updated_at timestamps
  }
}
