<?php
namespace App\Controllers;

use App\Models\Project;
use Respect\Validation\Validator as v;

class ProjectsController extends BaseController {
    public function getAddProjectAction($request) {
        $responseMessage = null;

        if ($request->getMethod() == 'POST') {
            $postData = $request->getParsedBody();
            $jobValidator = v::key('title', v::stringType()->notEmpty())
                  ->key('description', v::stringType()->notEmpty());

            try {
                $jobValidator->assert($postData);
                $postData = $request->getParsedBody();

                $files = $request->getUploadedFiles();
                $logo = $files['logo'];

                $filePath = "";
                if($logo->getError() == UPLOAD_ERR_OK) {
                    $fileName = $logo->getClientFilename();
                    $filePath = "uploads/$fileName";
                    $logo->moveTo("$filePath");
                }

                $job = new Project();
                $job->title = $postData['title'];
                $job->description = $postData['description'];
                $job->image = $filePath;
                $job->save();

                $responseMessage = 'Saved';
            } catch (\Exception $e) {
                $responseMessage = $e->getMessage();
            }
        }

        return $this->renderHTML('addProject.twig', [
            'responseMessage' =>$responseMessage
        ]);
    }
}
