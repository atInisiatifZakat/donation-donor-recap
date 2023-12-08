<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

final class DonationRecapTemplate extends Model
{
    protected $guarded = [];

    /**
     * @return resource|null
     */
    public function getPrefixStreamFile()
    {
        $disk = Storage::disk($this->getAttribute('disk'));

        $path = $this->getAttribute('prefix_file_path');

        return $disk->readStream($path);
    }

    /**
     * @return resource|null
     */
    public function getSuffixStreamFile()
    {
        $disk = Storage::disk($this->getAttribute('disk'));

        $path = $this->getAttribute('suffix_file_path');

        return $disk->readStream($path);
    }
}
