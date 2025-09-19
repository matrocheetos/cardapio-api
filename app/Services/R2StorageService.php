<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class R2StorageService
{
    /**
     * Faz o upload de um arquivo para o S3 e retorna o caminho.
     *
     * @param UploadedFile $file O arquivo recebido do request.
     * @param string $basePath O diretório base para o upload (ex: 'produtos/imagens').
     * @return string O caminho completo do arquivo salvo.
     */
    public function upload(UploadedFile $file, string $basePath): string
    {
        // 1. Verifica se é uma imagem
        if ($this->isImage($file)) {
            return $this->uploadImage($file, $basePath);
        }

        // 1. Gera um nome de arquivo único para evitar colisões.
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        // 2. Define o caminho completo (pasta + nome do arquivo).
        $path = "{$basePath}/{$filename}";

        // 3. Salva o arquivo no disco 's3'.
        Storage::disk('r2')->put($path, $file->get());

        // 4. Retorna o caminho para ser salvo no banco de dados.
        return $path;
    }

    /**
     * Deleta um arquivo do S3 a partir do seu caminho.
     *
     * @param string|null $path O caminho do arquivo a ser deletado.
     * @return void
     */
    public function delete(?string $path): void
    {
        if ($path) {
            Storage::disk('r2')->delete($path);
        }
    }

    /**
     * Retorna a URL pública de um arquivo.
     *
     * @param string|null $path O caminho do arquivo.
     * @return string|null A URL completa ou null se o caminho não existir.
     */
    public function getUrl(?string $path): ?string
    {
        if ($path) {
            return Storage::disk('r2')->url($path);
        }

        return null;
    }

    /**
     * Atualiza um arquivo: faz o upload do novo e deleta o antigo.
     *
     * @param UploadedFile $newFile O novo arquivo.
     * @param string|null $oldPath O caminho do arquivo antigo a ser substituído.
     * @param string $basePath O diretório base para o upload.
     * @return string O caminho do novo arquivo.
     */
    public function update(UploadedFile $newFile, ?string $oldPath, string $basePath): string
    {
        // Deleta o arquivo antigo primeiro.
        $this->delete($oldPath);

        // Faz o upload do novo arquivo.
        return $this->upload($newFile, $basePath);
    }


        /**
     * Verifica se o arquivo é uma imagem suportada.
     *
     * @param UploadedFile $file
     * @return bool
     */
    private function isImage(UploadedFile $file): bool
    {
        $imageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        return in_array($file->getMimeType(), $imageTypes);
    }

    /**
     * Faz upload de uma imagem, convertendo para WebP e otimizando.
     *
     * @param UploadedFile $file
     * @param string $basePath
     * @return string
     */
    private function uploadImage(UploadedFile $file, string $basePath): string
    {
        // 1. Gera um nome único com extensão .webp
        $filename = Str::uuid() . '.webp';
        $path = "{$basePath}/{$filename}";

        // 2. Processa a imagem com Intervention Image
        $image = Image::make($file->getRealPath())
            ->orientate() // Corrige orientação baseada em EXIF
            ->encode('webp', 85); // Converte para WebP com qualidade 85%

        // 3. Salva no R2
        Storage::disk('r2')->put($path, $image->stream()->getContents());

        return $path;
    }

    /**
     * Faz upload de uma imagem redimensionada para WebP.
     * Útil para criar thumbnails ou limitar o tamanho máximo.
     *
     * @param UploadedFile $file
     * @param string $basePath
     * @param int|null $maxWidth Largura máxima (mantém proporção)
     * @param int|null $maxHeight Altura máxima (mantém proporção)
     * @param int $quality Qualidade WebP (0-100)
     * @return string
     */
    public function uploadImageResized(
        UploadedFile $file,
        string $basePath,
        ?int $maxWidth = 1920,
        ?int $maxHeight = 1080,
        int $quality = 85
    ): string {
        $filename = Str::uuid() . '.webp';
        $path = "{$basePath}/{$filename}";

        $image = Image::make($file->getRealPath())
            ->orientate();

        // Redimensiona mantendo proporção se especificado
        if ($maxWidth || $maxHeight) {
            $image->resize($maxWidth, $maxHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize(); // Não aumenta se a imagem for menor
            });
        }

        $image->encode('webp', $quality);

        Storage::disk('r2')->put($path, $image->stream()->getContents());

        return $path;
    }
}