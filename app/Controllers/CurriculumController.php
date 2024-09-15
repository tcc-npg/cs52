<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\CurriculumEntity;
use App\Models\CurriculumModel;
use App\Models\SettingsModel;
use App\Models\SubjectModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class CurriculumController extends BaseController
{
    protected CurriculumModel $curriculumModel;
    protected SubjectModel $subjectModel;

    protected $helpers = ['_url', '_toast'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger): void
    {
        parent::initController($request, $response, $logger);

        $this->curriculumModel = model(CurriculumModel::class);
        $this->subjectModel = model(SubjectModel::class);
    }

    public function index(): string {
        return view('curriculum/index', [
            'curricula' => $this->curriculumModel->findAll(),
        ]);
    }

    public function subjectsList() {
        $settingsModel = model(SettingsModel::class);
        $currentCurriculum = $settingsModel->findByKey('current_curriculum')->value;
        return view('curriculum/subjects-list', [
            'subjects_list' => $this->subjectModel->where('curriculum_id', $currentCurriculum)->findAll(),
        ]);
    }

    public function subjectsUpdatePage(int $id) {
        $subjectToUpdate = $this->subjectModel->find($id);
        if ($subjectToUpdate) {
            return view('curriculum/subjects-update', [
                'subject' => $subjectToUpdate
            ]);
        } else {
            echo 'subject not found';
        }
    }

    public function subjectsUpdate(int $id) {
        $subjectToUpdate = $this->subjectModel->find($id);
        if ($subjectToUpdate) {
            $subjectToUpdate->code = $this->request->getPost('code');
            $subjectToUpdate->name = $this->request->getPost('name');

            $updateSuccessMessage = 'Update successful';
            $toastHeader = 'Success';
            $toastColor = 'success';
            $toastIcon = 'bxs-check-circle';

            try {
                $this->subjectModel->save($subjectToUpdate);
            } catch (DataException) {
                $updateSuccessMessage = 'No changes were made.';
                $toastColor = 'info';
                $toastHeader = 'Info';
                $toastIcon = 'bxs-info-circle';
            }
            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        } else {
            echo 'update fail';
        }
    }

    public function subjectsDelete(int $id) {
        $this->subjectModel->delete($id);
        $updateSuccessMessage = 'Delete successful';
        $toastHeader = 'Success';
        $toastColor = 'success';
        $toastIcon = 'bxs-check-circle';
        return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);

    }

    public function new(): string
    {
        return view('curriculum/new');
    }

    public function save(): RedirectResponse
    {

        $entity = new CurriculumEntity();
        $entity->description = $this->request->getPost('description');

        $this->curriculumModel->save($entity);

        $updateSuccessMessage = 'New Curriculum has been added';
        $toastHeader = 'Success';
        $toastColor = 'success';
        $toastIcon = 'bxs-check-circle';

        return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
    }
}
