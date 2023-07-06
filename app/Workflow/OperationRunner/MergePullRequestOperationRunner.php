<?php

namespace App\Workflow\OperationRunner;

use App\Models\PullRequest;
use App\Participants\Reviewer;
use PHPMentors\Workflower\Workflow\Activity\WorkItemInterface;
use PHPMentors\Workflower\Workflow\Operation\OperationalInterface;
use PHPMentors\Workflower\Workflow\Operation\OperationRunnerInterface;
use PHPMentors\Workflower\Workflow\ProcessInstance;

class MergePullRequestOperationRunner implements OperationRunnerInterface
{
    public function provideParticipant(OperationalInterface $operational, ProcessInstance $workflow)
    {
        return new Reviewer();
    }

    public function run(WorkItemInterface $workItem)
    {
        $pullRequest = PullRequest::findOrFail($workItem['id']);
        $pullRequest->merged = true;


        $pullRequest->save();
    }
}
