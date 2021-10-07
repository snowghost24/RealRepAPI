<?php

namespace Database\Seeders;

use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsArticleSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return Generator
     * @throws BindingResolutionException
     */
    protected function withFaker(): Generator
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('news_articles')->insert([[
            'title' => 'The Controversial Election Review In Arizona Confirms Biden\'s Win',
            'issuer' => 'npr.org',
            'to_question'=> "What should have been done about the ballot audit?",
            'media_link' => 'https://media.npr.org/assets/img/2021/09/23/ap_21266743810389_wide-24865207dd6dffdb337cb800930882c6648335fe-s1100-c50.jpg',
            'article_link' => 'https://www.npr.org/2021/09/24/1040327483/the-controversial-election-review-in-arizona-confirms-bidens-win',
            'course_of_action' => Str::random(10),
            'created_at'=> $this->faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null)
        ],[
            'title' => 'Former Louisiana State Police officer indicted on federal charge for allegedly beating a Black man with a flashlight',
            'issuer' => 'cnn.com',
            'to_question'=> "What should be done about police brutality?",
            'media_link' => 'https://cdn.cnn.com/cnnnext/dam/assets/210825235910-louisiana-state-police-car-exlarge-169.jpg',
            'article_link' => 'https://www.cnn.com/2021/09/23/us/louisiana-state-police-officer-indicted/index.html',
            'course_of_action' => Str::random(10),
            'created_at'=> $this->faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null)
        ],[
            'title' => 'Tennessee grocery store workers hid in freezers to survive a mass shooting that killed 1 woman and injured 14 others',
            'issuer' => 'cnn.com',
            'to_question'=> "What should be to combat mass shootings?",
            'media_link' => 'https://cdn.cnn.com/cnnnext/dam/assets/210923161900-collierville-kroger-shooting-medium-plus-169.jpg',
            'article_link' => 'https://www.cnn.com/2021/09/24/us/tennessee-colliersville-shooting-friday/index.html',
            'course_of_action' => Str::random(10),
            'created_at'=> $this->faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null)
        ],[
            'title' => 'China\'s top regulators ban crypto trading and mining, bitcoin stumbles',
            'issuer' => 'reuters.com',
            'to_question'=> "How should regulators tackle crypto?",
            'media_link' => 'https://www.reuters.com/resizer/T3Suff64Wvc_jM4s3_4m0HHnaf8=/1200x0/filters:quality(80)/cloudfront-us-east-2.images.arcpublishing.com/reuters/37CCDIYR6VPCZDLVEZASNSF6BU.jpg',
            'article_link' => 'https://www.reuters.com/world/china/china-central-bank-vows-crackdown-cryptocurrency-trading-2021-09-24/',
            'course_of_action' => Str::random(10),
            'created_at'=> $this->faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null)
        ]]);
    }
}
