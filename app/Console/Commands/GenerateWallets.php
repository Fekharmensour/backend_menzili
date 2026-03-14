<?php

namespace App\Console\Commands;

use App\Models\Member;
use Illuminate\Console\Command;

class GenerateWallets extends Command
{
    protected $signature = 'wallets:generate';
    protected $description = 'Generate wallets for existing members without a wallet';

    public function handle()
    {
        $members = Member::all(); // check all members

        $this->info('Generating wallets for '.$members->count().' members...');

        foreach ($members as $member) {
            // deposit will automatically create the wallet if missing
            $member->deposit(50, ['reason' => 'initial_bonus']);

            $this->info("Wallet created and 50 coins deposited for Member ID {$member->id}");
        }

        $this->info('Done!');
    }
}
