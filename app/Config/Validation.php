<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public array $userDetailsRules = [
        'first_name' => [
            'rules' => 'required|max_length[50]|min_length[2]',
            'errors' => [
                'required' => 'Your first name cannot be blank.',
                'min_length' => 'Your first name cannot have less than 2 characters.',
                'max_length' => 'Your first name cannot have more than 50 characters.',
            ],
        ],
        'middle_name' => [
            'rules' => 'max_length[50]',
            'errors' => [
                'max_length' => 'Your middle name cannot have more than 50 characters.',
            ],
        ],
        'last_name' => [
            'rules' => 'required|max_length[50]|min_length[2]',
            'errors' => [
                'required' => 'Your last name cannot be blank.',
                'min_length' => 'Your last name cannot have less than 2 characters.',
                'max_length' => 'Your last name cannot have more than 50 characters.',
            ],
        ],
        'address' => [
            'rules' => 'required|max_length[255]|min_length[2]',
            'errors' => [
                'required' => 'Your address cannot be blank.',
                'min_length' => 'Your address cannot have less than 2 characters.',
                'max_length' => 'Your address cannot have more than 255 characters.',
            ],
        ],
        'phone_number' => [
            'rules' => 'required|max_length[11]|min_length[10]',
            'errors' => [
                'required' => 'Your phone number cannot be blank.',
                'min_length' => 'Your phone number cannot have less than 10 characters.',
                'max_length' => 'Your phone number cannot have more than 11 characters.',
            ],
        ],
        'gender' => [
            'rules' => 'required|max_length[1]|min_length[1]',
            'errors' => [
                'required' => 'Your gender cannot be blank.',
                'min_length' => 'Your gender cannot have less than 1 character.',
                'max_length' => 'Your gender cannot have more than 1 character.',
            ],
        ]
    ];

    public array $studentDetailsRules = [
        'student_number' => [ // todo regex
            'rules' => 'required|max_length[10]|min_length[10]',
            'errors' => [
                'required' => 'Your student number cannot be blank.',
                'min_length' => 'Your student number cannot have less than 10 characters.',
                'max_length' => 'Your student number cannot have more than 10 characters.',
            ],
        ],
        'year_level' => [
            'rules' => 'required|not_in_list["1","2","3","4"]',
            'errors' => [
                'required' => 'Your year level cannot be blank.',
                'not_in_list' => 'Your year level must be an integer between 1 and 4.',
            ],
        ],
        'program_code' => [
            'rules' => 'required|max_length[10]|min_length[2]',
            'errors' => [
                'required' => 'Your program cannot be blank.',
                'min_length' => 'Your student number cannot have less than 2 characters.',
                'max_length' => 'Your student number cannot have more than 10 characters.',
            ],
        ]
    ];
}
