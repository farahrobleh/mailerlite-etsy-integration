<?php

namespace App\Services;

class MailerLiteMockService
{
    public function createGroup($name)
    {
        return [
            'id' => 'mock_group_' . rand(1000, 9999),
            'name' => $name,
            'created_at' => now()->toISOString()
        ];
    }

    public function addSubscriberToGroup($groupId, $email, $name)
    {
        return [
            'id' => 'mock_subscriber_' . rand(1000, 9999),
            'email' => $email,
            'name' => $name,
            'group_id' => $groupId,
            'status' => 'active'
        ];
    }

    public function createCampaign($title, $content)
    {
        return [
            'id' => 'mock_campaign_' . rand(1000, 9999),
            'title' => $title,
            'content' => $content,
            'status' => 'sent',
            'sent_at' => now()->toISOString(),
            'analytics' => [
                'open_rate' => rand(20, 80) . '%',
                'click_rate' => rand(5, 30) . '%',
                'subscribers_reached' => rand(50, 200)
            ]
        ];
    }

    public function createAutomation($name, $trigger, $action)
    {
        return [
            'id' => 'mock_automation_' . rand(1000, 9999),
            'name' => $name,
            'trigger' => $trigger,
            'action' => $action,
            'status' => 'active'
        ];
    }

    public function getAutomations()
    {
        return [
            [
                'id' => 'mock_automation_1234',
                'name' => 'Welcome Email',
                'trigger' => 'subscriber_added',
                'action' => 'send_welcome_email',
                'status' => 'active'
            ]
        ];
    }
}