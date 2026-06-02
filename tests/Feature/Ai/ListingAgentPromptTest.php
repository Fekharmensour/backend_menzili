<?php

use App\Ai\Agents\ListingAgent;

it('loads the external listing agent prompt and injects support details', function () {
    putenv('AI_SUPPORT_EMAIL=support@menzili.test');
    putenv('AI_SUPPORT_PHONE=+213555000111');
    putenv('AI_SUPPORT_WHATSAPP=whatsapp:+213555000111');
    putenv('AI_SUPPORT_HOURS=Sun-Thu 09:00-17:00');

    $prompt = (new ListingAgent())->instructions();

    expect($prompt)
        ->toContain('support@menzili.test')
        ->toContain('+213555000111')
        ->toContain('whatsapp:+213555000111')
        ->toContain('Sun-Thu 09:00-17:00')
        ->toContain('SUPPORT / CONTACT RULES')
        ->toContain('PLATFORM GUIDE');
});
