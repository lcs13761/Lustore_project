<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HandlerImages
{
    private $image;
    private null|string $imageExistence;

    /**
     * Verificar a Imagem recebida
     *
     * @param mixed $image
     * @param string|null $imageExistence
     * @param bool $removeImage
     * @return ?static
     */
    public function upload(mixed $image, ?string $imageExistence = null, ?bool $removeImage = false): ?static
    {
        $this->imageExistence = $imageExistence;

        if ($image || $removeImage) {
            $this->deleteImage($imageExistence);
            $this->imageExistence = null;
        }

        $this->image = $image;
        return $this;
    }

    /**
     * Definir a pasta que sera salvo o arquivo
     *
     * @param string $folder
     * @return static
     */

    /**
     * Salvar o arquivo, e necessários informar a pasta de persistência do arquivo
     *
     * @param string $folder
     * @return null|string
     */
    public function saveIn(?string $folder = null): ?string
    {
        /** @var Illuminate\Filesystem\FilesystemAdapter */
        $disk =  Storage::disk('public');

        $folder = $folder ?? (isset($this->folder) ? $this->folder : 'default');

        return !$this->image ? $this->imageExistence : $disk->putFile($folder, $this->image);
    }

    /**
     * Remover Imagem
     *
     * @param string $image
     * @return void
     */
    public function deleteImage($image = null)
    {
        if ($this->hasFile($image)) {
            Storage::disk('public')->delete($image);
        }
    }

    /**
     * Verificar ser o arquivo existe
     *
     * @param [type] $file
     * @return boolean
     */
    public function hasFile($file): bool
    {
        return !$file ? false : Storage::disk('public')->exists($file);
    }


    /**
     * Undocumented function
     *
     * @param [type] $folder
     * @param [type] $file
     * @return string|null
     */
    private function saveFile($folder = null, $file = null): ?string
    {
        $file = $file ?? $this->image;

        /** @var Illuminate\Filesystem\FilesystemAdapter */
        $disk =  Storage::disk('public');

        return !$file ? $this->imageExistence : $disk->putFile($folder ?? $this->folder, $file);
    }
}
