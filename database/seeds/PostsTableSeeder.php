<?php

use App\Post;
use App\Category;
use App\Tag;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category1 = Category::create([
            'name' => 'News'
        ]);
        $author1 = User::create([
            'name' => 'Francis',
            'email' => 'francis@gmail.com',
            'password' => Hash::make('password')
        ]);

        $author2 = User::create([
            'name' => 'Oluchi',
            'email' => 'oluchi@gmail.com',
            'password' => Hash::make('password')
        ]);

        $category2 = Category::create([
            'name' => 'Marketing'
        ]);
        $category3 = Category::create([
            'name' => 'Partnership'
        ]);
       
        $post1 = Post::create([
            'title'=> 'We relocated our office to a new designed garage',
            'description' =>'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
            'content'=>' Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
            'category_id'=> $category1->id,
            'image'=> 'posts/1.jpg',
            'user_id' => $author1->id
        ]);
        $post2 = $author2->posts()->create([ //This is an alternative to the using the user_id=>$author_id
            'title'=> 'Top 5 brilliant content marketing strategies',
            'description' =>'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
            'content'=>' Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
            'category_id'=> $category2->id,
            'image'=> 'posts/2.jpg'
        ]);
        $post3 = $author1->posts()->create([ //This takes the post relationship in the User model since it is one to many relationship
            'title'=> 'Best practices for minimalist design with examples',
            'description' =>'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
            'content'=>' Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
            'category_id'=> $category3->id,
            'image'=> 'posts/3.jpg'
        ]);
        $post4 = $author2->posts()->create([
            'title'=> 'Congratulations and thanks to Francis for joining our team',
            'description' =>'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
            'content'=>' Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
            'category_id'=> $category2->id,
            'image'=> 'posts/4.jpg'
        ]);
        $tag1 = Tag::create([
            'name' => 'Job'
        ]);
        $tag2 = Tag::create([
            'name' => 'Customers'
        ]);
        $tag3 = Tag::create([
            'name' => 'record'
        ]);

        $post1->tags()->attach([$tag1->id, $tag2->id]);
        $post2->tags()->attach([$tag2->id, $tag3->id]);
        $post3->tags()->attach([$tag1->id, $tag3->id]);
        

    }
}
