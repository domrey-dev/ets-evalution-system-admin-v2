<?php

namespace Database\Seeders;

use App\Models\Evaluations;
use App\Models\EvaluationCriteria;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default evaluation template
        $evaluation = Evaluations::create([
            'title' => 'Standard Performance Evaluation Form',
            'created_by' => 1, // Admin user
            'updated_by' => 1,
        ]);

        // Default evaluation criteria based on the official form
        $criteria = [
            [
                'order_number' => 1,
                'title_kh' => 'គុណភាពនៃការងារ',
                'title_en' => 'Quality of work',
                'description_kh' => 'ភាពឥតខ្ចោះ និងភាពជឿជាក់ក្នុងការងារ',
                'description_en' => 'Accuracy and consistency of work, attention to details',
                'weight' => 1.0,
            ],
            [
                'order_number' => 2,
                'title_kh' => 'បរិមាណនៃការងារ',
                'title_en' => 'Quantity of work',
                'description_kh' => 'ទំហំការងារដែលសម្រេចបានទាន់ពេលវេលា',
                'description_en' => 'Amount of work, completion of work on time',
                'weight' => 1.0,
            ],
            [
                'order_number' => 3,
                'title_kh' => 'ចំណេះដឹងការងារ',
                'title_en' => 'Job Knowledge',
                'description_kh' => 'កម្រិតចំណេះដឹងពេលបច្ចុប្បន្ន សមត្ថភាពក្នុងការរៀនសូត្រ',
                'description_en' => 'Current level of job knowledge and experiences, ability to learn and adapt as the job changes or work satisfactory.',
                'weight' => 1.0,
            ],
            [
                'order_number' => 4,
                'title_kh' => 'ការផ្តួចផ្តើមគំនិត',
                'title_en' => 'Initiatives',
                'description_kh' => 'សមត្ថភាពក្នុងការធ្វើការដោយ ការទទួលខុសត្រូវលើការងារ ចេះផ្តល់យោបល់និងចូលរួមចំនែកក្នុងការសម្រេចចិត្ត',
                'description_en' => 'Ability to work with limited supervision, takes accountability for work, makes suggestions and decisions, bring new ideas to discuss with supervisor...',
                'weight' => 1.0,
            ],
            [
                'order_number' => 5,
                'title_kh' => 'ការងារជាក្រុម និង ការសហការណ៍',
                'title_en' => 'Team work & Corporation',
                'description_kh' => 'សមត្ថភាពធ្វើការនិងការសហការណ៍បានល្អជាមួយបុគ្គលិកដទៃ',
                'description_en' => 'Ability to work and corporate well with others',
                'weight' => 1.0,
            ],
            [
                'order_number' => 6,
                'title_kh' => 'ការប្រាស្រ័យទាក់ទង',
                'title_en' => 'Communication',
                'description_kh' => 'ច្បាស់លាស់ និងប្រសិទ្ធភាពចំពោះការងារទាំងការនិយាយ និងការសរសេរ (ភាសាខ្មែរនិងអង់គ្លេស)',
                'description_en' => 'Clarity and effectiveness when speaking, writing & communicate both languages Khmer and English',
                'weight' => 1.0,
            ],
            [
                'order_number' => 7,
                'title_kh' => 'ការគោរពពេលវេលា និង សុវត្ថិភាពការងារ',
                'title_en' => 'Respect to time and safety',
                'description_kh' => 'វត្តមាននិងការគោរពពេលវេលា គោរពគោលការសុវត្ថិភាព និងការគោរពវិន័យផ្សេងៗ',
                'description_en' => 'Attendance and punctuality, complies with safety and other regulations',
                'weight' => 1.0,
            ],
            [
                'order_number' => 8,
                'title_kh' => 'ការគ្រប់គ្រង',
                'title_en' => 'Managing',
                'description_kh' => 'ការដឹកនាំក្រុម ការរៀបចំ និងការធ្វើផែនការ (បើសិនជាមាន)',
                'description_en' => 'leading people, organizing and planning resources (if applicable)',
                'weight' => 1.0,
            ],
            [
                'order_number' => 9,
                'title_kh' => 'ការជឿទុកចិត្ត',
                'title_en' => 'Reliability',
                'description_kh' => 'គោរពតាមច្បាប់ការងារ ទទួលខុសត្រូវការងារ ភាពស្មោះត្រង់',
                'description_en' => 'the quality of being able to be trusted or believed because of work',
                'weight' => 1.0,
            ],
            [
                'order_number' => 10,
                'title_kh' => 'កត្តាផ្សេងៗ',
                'title_en' => 'Other',
                'description_kh' => 'ការផ្តល់គំនិតយោបល់ក្នុងការបង្កើនផលិតភាពគារងារ',
                'description_en' => 'Option to specify any other important aspects of performance in this job',
                'weight' => 1.0,
            ],
        ];

        foreach ($criteria as $criteriaData) {
            EvaluationCriteria::create([
                'evaluations_id' => $evaluation->id,
                'title_kh' => $criteriaData['title_kh'],
                'title_en' => $criteriaData['title_en'],
                'description_kh' => $criteriaData['description_kh'],
                'description_en' => $criteriaData['description_en'],
                'order_number' => $criteriaData['order_number'],
                'weight' => $criteriaData['weight'],
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }

        $this->command->info('Created default evaluation template with 10 standard criteria.');
    }
} 