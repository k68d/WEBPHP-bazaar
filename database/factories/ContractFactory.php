<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition(): array
    {
        // Haal twee unieke gebruikers op. Maak nieuwe aan indien nodig.
        $userOne = User::inRandomOrder()->first() ?? User::factory()->create();
        $userTwo = User::where('id', '!=', $userOne->id)->inRandomOrder()->first() ?? User::factory()->create();

        $descriptions = [
            'Lease agreement for residential apartment located at Central Park.',
            'Freelance web development services for a startup company website redesign.',
            'Consulting agreement for marketing strategy development and implementation.',
            'Sales contract for a used 2018 Toyota Corolla, including warranty details.',
            'Employment contract outlining job responsibilities, salary, and benefits.',
            'Software license agreement for a project management tool, up to 50 users.',
            'Non-disclosure agreement to protect confidential information during negotiations.',
            'Rental agreement for professional camera equipment for a wedding event.',
            'Service contract for monthly landscaping and garden maintenance.',
            'Publishing agreement for a cookbook with recipes and images.',
            'Contract for architectural services for a home renovation project.',
            'Exclusive distribution agreement for a new line of organic skincare products.',
            'Partnership agreement for the opening of a new restaurant location.',
            'Maintenance contract for HVAC systems in a commercial building.',
            'Personal training services agreement, including sessions schedule and payment terms.',
            'Event planning and management contract for a corporate retreat.',
            'Legal services retainer agreement for small business counsel and representation.',
            'Franchise agreement for operating a branded coffee shop.',
            'Construction contract for a new office building, including timelines and costs.',
            'Loan agreement detailing terms, interest rate, and repayment schedule.',
            'Cleaning services contract for office spaces, with specifics on areas and frequency.',
            'Property management agreement for residential apartments, including services and fees.',
            'Graphic design services contract for branding and promotional materials.',
            'Catering contract for a wedding, including menu details and guest count.',
            'Technology consulting services agreement for implementing a new IT infrastructure.',
        ];

        $additionalInfos = [
            'Pets are not allowed in the apartment.',
            'Website must be delivered within 3 months from the start date.',
            'Marketing materials to be approved by the client before public release.',
            'Car to be delivered after completing payment and necessary paperwork.',
            'Employee is eligible for health and dental benefits after 90 days of employment.',
            'Software updates and support included for the first year.',
            'Any disclosed information must remain confidential for a period of 5 years.',
            'Equipment must be returned in good condition, or a fee will be charged.',
            'Landscaping services do not include tree removal or major landscape redesign.',
            'Author retains rights to recipes but grants exclusive publishing rights.',
            'Architect to provide preliminary designs within 6 weeks.',
            'Distributor agrees not to sell competing products.',
            'Partners share profits and losses equally.',
            'Routine maintenance to be performed quarterly.',
            'Client must cancel at least 24 hours in advance to avoid session charge.',
            'Event date set for June 15th, with a backup date in case of bad weather.',
            'Retainer covers up to 20 hours of legal work per month.',
            'Franchisee must adhere to all brand standards and training requirements.',
            'Building completion expected by Q4 2023, barring unforeseen delays.',
            'Loan must be fully repaid within 10 years, with early repayment options.',
            'Cleaning to occur after business hours, three times a week.',
            'Manager to handle all tenant communications and repairs under $500 without prior approval.',
            'All designs to be delivered in vector format.',
            'Menu selections must be finalized 30 days before the event.',
            'Project to kick off with a strategy meeting the first week of the contract.',
        ];

        return [
            'user_id_one' => $userOne->id,
            'user_id_two' => $userTwo->id,
            'description' => $this->faker->randomElement($descriptions),
            'contract_date' => $this->faker->dateTimeBetween('now', '+5 years')->format('Y-m-d'),
            'status' => $this->faker->randomElement(['Active', 'Complete', 'Mockup']),
            'additional_info' => $this->faker->randomElement($additionalInfos),
        ];
    }
}
