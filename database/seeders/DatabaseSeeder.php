<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_SUPER_ADMIN,
            'status' => User::STATUS_ACTIVE,
            'email_verified_at' => now(),
        ]);

        User::query()->create([
            'name' => 'Panel Admin',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
            'email_verified_at' => now(),
        ]);

        $samples = [
            [
                'handler_name' => 'James Mitchell',
                'certificate_number' => 'BASDU/OA/2025/0147',
                'date_of_assessment' => '2025-03-12',
                'training_organization' => 'BASDU Operational Assessment Unit',
                'assessor_name' => 'Capt. Laura Hayes',
                'result' => 'PASS',
                'status' => 'active',
            ],
            [
                'handler_name' => 'Sarah Thompson',
                'certificate_number' => 'BASDU/OA/2025/0148',
                'date_of_assessment' => '2025-04-02',
                'training_organization' => 'National K9 Security Academy',
                'assessor_name' => 'Maj. David Cole',
                'result' => 'PASS',
                'status' => 'active',
            ],
            [
                'handler_name' => 'Omar Farooq',
                'certificate_number' => 'BASDU/OA/2025/0149',
                'date_of_assessment' => '2025-05-18',
                'training_organization' => 'BASDU Operational Assessment Unit',
                'assessor_name' => 'Capt. Laura Hayes',
                'result' => 'FAIL',
                'status' => 'active',
            ],
            [
                'handler_name' => 'Emily Carter',
                'certificate_number' => 'BASDU/OA/2025/0150',
                'date_of_assessment' => '2025-06-09',
                'training_organization' => 'Canine Defense Institute',
                'assessor_name' => 'Lt. Mark Benson',
                'result' => 'PASS',
                'status' => 'active',
            ],
            [
                'handler_name' => 'Daniel Okonkwo',
                'certificate_number' => 'BASDU/OA/2025/0151',
                'date_of_assessment' => '2025-07-21',
                'training_organization' => 'National K9 Security Academy',
                'assessor_name' => 'Maj. David Cole',
                'result' => 'PASS',
                'status' => 'inactive',
            ],
            [
                'handler_name' => 'Priya Sharma',
                'certificate_number' => 'BASDU/OA/2026/0001',
                'date_of_assessment' => '2026-01-14',
                'training_organization' => 'BASDU Operational Assessment Unit',
                'assessor_name' => 'Capt. Laura Hayes',
                'result' => 'PASS',
                'status' => 'active',
            ],
            [
                'handler_name' => 'Lucas Bernard',
                'certificate_number' => 'BASDU/OA/2026/0002',
                'date_of_assessment' => '2026-02-03',
                'training_organization' => 'Canine Defense Institute',
                'assessor_name' => 'Lt. Mark Benson',
                'result' => 'FAIL',
                'status' => 'inactive',
            ],
            [
                'handler_name' => 'Aisha Rahman',
                'certificate_number' => 'BASDU/OA/2026/0003',
                'date_of_assessment' => '2026-03-27',
                'training_organization' => 'National K9 Security Academy',
                'assessor_name' => 'Maj. David Cole',
                'result' => 'PASS',
                'status' => 'active',
            ],
        ];

        foreach ($samples as $sample) {
            $certificate = Certificate::query()->create($sample);

            if ($certificate->handler_name === 'James Mitchell') {
                Comment::query()->create([
                    'certificate_id' => $certificate->id,
                    'name' => 'Security Manager',
                    'comment' => 'Verified for site deployment. Excellent operational readiness.',
                    'status' => Comment::STATUS_APPROVED,
                ]);
                Comment::query()->create([
                    'certificate_id' => $certificate->id,
                    'name' => 'Visitor',
                    'comment' => 'Waiting for confirmation from HQ.',
                    'status' => Comment::STATUS_PENDING,
                ]);
            }

            if ($certificate->handler_name === 'Sarah Thompson') {
                Comment::query()->create([
                    'certificate_id' => $certificate->id,
                    'name' => 'HR Officer',
                    'comment' => 'Certificate details match our personnel file.',
                    'status' => Comment::STATUS_APPROVED,
                ]);
            }
        }
    }
}
