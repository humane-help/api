<?php

namespace App\Services;

use App\Exceptions\UnexpectedErrorException;
use App\Helpers\FileHelper;
use App\Models\Image;
use App\Repositories\Contracts\ImageRepository;
use App\Services\Contracts\ImageService as ImageServiceInterface;
use App\Services\Traits\ServiceTranslateTable;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use Illuminate\Support\Arr;

/**
 * Class ImageService
 * @package App\Services
 * @method bool destroy
 */
class ImageService  extends BaseService implements ImageServiceInterface
{
    use ServiceTranslateTable;

    /**
     * @var DatabaseManager $databaseManager
     */
    protected $databaseManager;

    /**
     * @var ImageRepository $repository
     */
    protected $repository;

    /**
     * Language $language
     */
    protected $language;

    /**
     * @var Logger $logger
     */
    protected $logger;

    /**
     * @var FileHelper $fileHelper
     */
    protected $fileHelper;

    /**
     * ImageService constructor.
     *
     * @param DatabaseManager $databaseManager
     * @param ImageRepository $repository
     * @param Logger $logger
     * @param FileHelper $fileHelper
     */
    public function __construct(
        DatabaseManager $databaseManager,
        ImageRepository $repository,
        Logger $logger,
        FileHelper $fileHelper
    ) {

        $this->databaseManager     = $databaseManager;
        $this->repository     = $repository;
        $this->logger     = $logger;
        $this->fileHelper     = $fileHelper;
    }

    /**
     * Create image
     *
     * @param array $data
     * @return Image
     * @throws \Exception
     */
    public function upload(array $data)
    {

        $this->beginTransaction();

        try {
            /** @var Image $image */
            $image = $this->repository->newInstance();
            $attributes = $this->storeImage($data);
            $image->fill($attributes);
            if ($image->file) {
                $image->file = config('filesystems.disks.public.url') . preg_replace('#public#', '', $image->file);
            }
            if (!$image->save()) {
                throw new UnexpectedErrorException('Image was not saved to the database.');
            }
            $this->logger->info('Image was successfully saved to the database.');
        } catch (UnexpectedErrorException $e) {
            $this->rollback($e, 'An error occurred while storing an ', [
                'data' => $data,
            ]);
        }

        $this->commit();

        return $image;
    }

    /**
     * Upload file
     */
    protected function storeImage(array $data){

        $dataFields =[];
        if(Arr::has($data,'file')) {
            $uploadedFile  = $data['file'];
            $dataFields['file'] = $this->fileHelper->upload($uploadedFile,'/img/content');
        }
        return $dataFields;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method bool destroy
    }
}
