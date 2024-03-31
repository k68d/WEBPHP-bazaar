<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Advertisement;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertisement>
 */
class AdvertisementFactory extends Factory
{
    protected $model = Advertisement::class;

    public function definition(): array
    {
        $titles = [
            'Complete Guide to Baking',
            'Top 10 DIY Home Repairs',
            'Gardening for Beginners',
            'Easy Car Maintenance Tips',
            'Cooking Secrets of Chefs',
            'Mastering Portrait Photography',
            'The Art of Making Sushi',
            'Beginner’s Guide to Yoga',
            'Exploring the World of Craft Beer',
            'How to Start Your Own Podcast',
            'Building a Small Business Website',
            'Essential Tips for Freelancers',
            'Understanding Basic Nutrition',
            'Fitness Routines for Busy People',
            'The Joy of Painting Landscapes',
            'Creative Writing for Beginners',
            'Making the Perfect Espresso',
            'Indoor Plants for Clean Air',
            'Budget Travel Hacks',
            'The Science of Happiness',
            'Quick and Healthy Meal Prep',
            'Learning to Play the Guitar',
            'Sustainable Living Tips',
            'Decorating Your First Apartment',
            'Improving Your Memory Skills',
            'Cycling Routes for Beginners',
            'Effective Time Management Strategies',
            'Basics of Personal Finance',
            'Introduction to Bird Watching',
            'Easy Home Organizing Tricks',
            'Brewing Your First Beer at Home',
            'The World of Vintage Watches',
            'Guide to Collecting Vinyl Records',
            'Starting a Book Club',
            'Beginner’s Guide to Meditation',
            'Smart Home Gadgets Explained',
            'Parenting Tips for New Parents',
            'Navigating Your Career Path',
            'The Basics of Coding',
            'Discovering New Music Genres',
            'Planning the Perfect Picnic',
            'Learning a Second Language',
            'The History of Coffee',
            'Understanding Wine Varietals',
            'Eco-Friendly Fashion Choices',
            'Developing a Reading Habit',
            'Tips for Healthy Skin',
            'Getting Started with Journaling',
            'Home Workout Routines',
            'The Importance of Digital Detox',
        ];

        $descriptions = [
            'Learn the secrets to baking delicious bread, pastries, and cakes with our comprehensive guide.',
            'Discover how to handle common household repairs with these top DIY tips and save money.',
            'This beginner’s guide will show you how to start your garden, even if you’ve never planted a seed before.',
            'Maintain your vehicle in top condition with our easy-to-follow car maintenance tips.',
            'Uncover the cooking techniques that chefs use to create mouthwatering dishes.',
            'Capture stunning portraits with tips from professional photographers.',
            'Dive into the art of sushi making with our detailed guide, perfect for beginners.',
            'Embark on your yoga journey with confidence with this guide designed for new practitioners.',
            'Explore the rich world of craft beer with our guide to styles, brewing, and tasting.',
            'Step-by-step guide to starting your own podcast, from equipment to production.',
            'Create a professional website for your small business with our easy-to-follow guide.',
            'Maximize your freelance potential with essential tips and strategies for success.',
            'Get to know the basics of nutrition and how to apply them to your daily meals.',
            'Find fitness routines that fit into your busy schedule and keep you in shape.',
            'Discover the joy of painting landscapes with our beginner-friendly guide.',
            'Explore creative writing with this guide, perfect for those looking to start their writing journey.',
            'Master the art of espresso making with our expert tips and tricks.',
            'Learn about the best indoor plants for purifying the air and how to care for them.',
            'Travel more for less with these budget-friendly travel hacks.',
            'Explore the science behind happiness and how to apply it to your daily life.',
            'Prepare quick and healthy meals with our meal prep guide for busy people.',
            'Learn the basics of playing the guitar with this guide for absolute beginners.',
            'Discover simple steps to live a more sustainable and eco-friendly life.',
            'Decorate your first apartment like a pro with these simple tips and tricks.',
            'Improve your memory and cognitive skills with these effective techniques.',
            'Find the best cycling routes for beginners and tips for getting started.',
            'Manage your time more effectively with strategies that work.',
            'Learn the basics of managing your personal finances with our easy guide.',
            'Discover the fascinating world of bird watching and how to get started.',
            'Organize your home quickly and efficiently with these easy tricks.',
            'Brew your first batch of beer at home with this beginner’s guide.',
            'Explore the world of vintage watches and what makes them so special.',
            'Start your vinyl record collection with tips on what to look for and where to find the best records.',
            'Everything you need to know to start and run a successful book club.',
            'Find peace and improve your mental health with our beginner’s guide to meditation.',
            'Understand how smart home gadgets work and which ones are right for you.',
            'Get practical parenting advice for the challenging first years.',
            'Navigate your career path successfully with our expert advice and tips.',
            'Dive into the world of coding with this basic guide for absolute beginners.',
            'Discover new music genres and expand your musical horizons.',
            'Plan the perfect picnic with these tips, from choosing a spot to what to pack.',
            'Learning a second language can be easy and fun with our practical tips.',
            'Dive into the rich history of coffee from its origins to modern-day brewing techniques.',
            'Understand the different wine varietals and how to enjoy them.',
            'Make eco-friendly fashion choices without sacrificing style.',
            'Develop a reading habit that sticks with these helpful tips.',
            'Achieve healthy, glowing skin with our simple skincare tips.',
            'Start journaling with our guide and discover its many benefits for mental health.',
            'Stay fit at home with these effective workout routines.',
            'Learn the importance of taking breaks from digital devices for your mental health.',
        ];

        return [
            'title' => $this->faker->randomElement($titles),
            'description' => $this->faker->randomElement($descriptions),
            'price' => $this->faker->numberBetween(10, 1000),
            'type' => $this->faker->randomElement(['verhuur', 'normaal']),
            'image_path' => $this->faker->imageUrl(640, 480, 'business', true),
            'user_id' => User::all()->random()->id, // Consider using User::inRandomOrder()->first()->id for better performance on large datasets
        ];
    }
}
