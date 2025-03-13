<?php

namespace Database\Seeders;

use App\Models\Enums\Section\SectionSlug;
use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SectionSlug::cases() as $section) {
            Section::query()->updateOrCreate(['slug' => $section->value],
                [
                    'title' => $section->title(),
                    'slug' => $section->value,
                ]
            );
        }

        Section::query()->whereNotIn('slug', array_column(SectionSlug::cases(), 'value'))->delete();
    }


}
