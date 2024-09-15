<?php

namespace App\Controllers;

use App\Models\CurriculumModel;
use App\Models\SettingsModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;

class SettingsController extends BaseController
{
    protected $helpers = ['form', '_url', '_toast'];

    protected SettingsModel $settingsModel;

    protected array $groups = ['academic' => [], 'accounts' => []];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger): void
    {
        parent::initController($request, $response, $logger);
        $this->settingsModel = model(SettingsModel::class);
        $result = $this->settingsModel->findByClass(array_keys($this->groups));
        $this->groupByClass($result);

    }

    public function index(): string
    {
        $curriculaModel = model(CurriculumModel::class);
        return view('settings/settings', [
            'groups' => $this->groups,
            'curricula' => $curriculaModel->findAll()
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function save(): RedirectResponse
    {
        $form = $this->request->getPost('form');

        $updateSuccessMessage = 'No changes were made.';
        $toastColor = 'info';
        $toastHeader = 'Info';
        $toastIcon = 'bxs-info-circle';

        switch ($form) {
            case 'academic':
                if ($this->updateAcademicClassValues()) {
                    $updateSuccessMessage = 'Academic settings have been successfully updated!';
                    $toastHeader = 'Success';
                    $toastColor = 'success';
                    $toastIcon = 'bxs-check-circle';
                }
                break;
            case 'accounts':
                if ($this->updateAccountClassValues()) {
                    $updateSuccessMessage = 'Account settings have been successfully updated!';
                    $toastHeader = 'Success';
                    $toastColor = 'success';
                    $toastIcon = 'bxs-check-circle';
                }
                break;
            default:
                $updateSuccessMessage = 'An error was encountered while saving profile details.';
                $toastHeader = 'Error';
                $toastColor = 'danger';
                $toastIcon = 'bxs-x-circle';
                break;
        }
        return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
    }

    private function updateAcademicClassValues(): bool
    {
        $requestData = $this->request->getPost();

        foreach ($this->groups['academic'] as $setting) {
            if (array_key_exists($setting->key, $requestData)) {
                $setting->value = $requestData[$setting->key];
                try {
                    return $this->settingsModel->save($setting);
                } catch (DataException) {
                    return false;
                }
            }
        }
        return false;
    }


    /**
     * @throws ReflectionException
     */
    private function updateAccountClassValues(): bool
    {
        $item = $this->groups['accounts']['registration_enabled'];
        $item->value = $this->request->getPost('registration_enabled') === 'on' ? '1' : '0';
        if (!$item->hasChanged()) {
            return false;
        }
        return $this->settingsModel->save($item);
    }

    private function groupByClass(array $settings): void
    {
        foreach ($settings as $setting) {
            $this->groups[$setting->class][$setting->key] = $setting;
        }
    }
}
