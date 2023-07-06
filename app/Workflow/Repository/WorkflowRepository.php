<?php

namespace App\Workflow\Repository;

use App\Workflow\Exceptions\UnsupportedMethodException;
use App\Workflow\Exceptions\WorkflowException;
use Log;
use PHPMentors\Workflower\Definition\Bpmn2Reader;
use PHPMentors\Workflower\Workflow\ProcessInstance;
use PHPMentors\Workflower\Workflow\WorkflowRepositoryInterface;
use Storage;
use PHPMentors\Workflower\Definition\ProcessDefinitionRepository;

class WorkflowRepository implements WorkflowRepositoryInterface
{
    private $filePath;
    private $definitions;

    public function __construct()
    {
        $this->definitions = new ProcessDefinitionRepository();
    }

    public function findById($filePath): ?ProcessInstance
    {
        
        try {
            $this->filePath = $filePath;
            $processDefinition = $this->getProcessDefinition();
            return $processDefinition->createProcessInstance();
        } catch (\Exception $e) {
            Log::error($e);
            throw new WorkflowException("Error en la lectural del archivo en workflower", 1);
        }
    }

    private function getProcessDefinition(): \PHPMentors\Workflower\Workflow\ProcessDefinitionInterface
    {
        $this->definitions->importFromFile($this->getStorageFilePath());
        return $this->definitions->getLatestById($this->getProcessId());
    }
    
    private function getProcessId()
    {
        return "Process_1";
    }

    private function getRelativeFilePath()
    {
        return "process/{$this->filePath}";
    }

    private function getStorageFilePath()
    {
        return Storage::path($this->getRelativeFilePath());
    }

    public function add($workflow) : void
    {
        throw new UnsupportedMethodException("Metodo no necesario para la implementacion", 1);
    }

    public function remove($workflow): void
    {
        throw new UnsupportedMethodException("Metodo no necesario para la implementacion", 1);
    }
}
