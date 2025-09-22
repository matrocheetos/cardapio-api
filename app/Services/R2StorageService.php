<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

final class R2StorageService
{
    /**
     * Faz o upload de um arquivo para o S3 e retorna o caminho.
     */
    public function upload(UploadedFile $file, string $filename, string $basePath, string $visibility = 'private'): string
    {
        if ($this->isImage($file)) {
            $filename .= '.webp';
            $fileStr = $this->convertToWebp($file);
        } else {
            $filename .= '.' . $file->guessExtension();
            $fileStr = $file->get();
        }

        $path = $basePath.'/'.$filename;

        Storage::put($path, $fileStr, $visibility);

        return $path;
    }

    /**
     * Deleta um arquivo do S3 a partir do seu caminho.
     */
    public function delete(?string $path): void
    {
        if ($path) {
            Storage::delete($path);
        }
    }

    /**
     * Retorna a URL pública de um arquivo.
     */
    public function getUrl(string $path): ?string
    {
        if (Storage::exists($path)) {
            return Storage::url($path);
        }
        return null;
    }

    /**
     * Verifica se o arquivo é uma imagem suportada.
     */
    private function isImage(UploadedFile $file): bool
    {
        $imageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        return in_array($file->getMimeType(), $imageTypes);
    }

    /**
     * Converte uma imagem para WebP e otimiza.
     */
    private function convertToWebp(UploadedFile $file): string
    {
        $image = Image::read($file);

        // qualidade 75%, remove metadados
        $image = $image->toWebp(75, true);

        return (string) $image;
    }
}