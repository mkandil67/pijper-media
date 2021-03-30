<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class dummyPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::create(array(
            'category' => 'News',
            'platform' => 'Facebook',
            'caption' => 'In Eindhoven reed deze Porsche een woning binnen. De bestuurder is er vandoor gegaan en wordt gezocht. Omwonenden vermoeden dat er opzet in het spel is.',
            'post_url' => 'https://www.facebook.com/nos/posts/4642077755807746',
            'image_url' => 'https://external-ams4-1.xx.fbcdn.net/safe_image.php?d=AQGeBwZosZGsHKRT&w=500&h=261&url=https%3A%2F%2Fcdn.nos.nl%2Fimage%2F2021%2F03%2F20%2F725616%2Fxxl.jpg&cfs=1&ext=jpg&_nc_cb=1&ccb=3-4&_nc_hash=AQG9akdx332ZrrTl',
            'engagement' => 236,
            'old_engagement' => 10,
            'writer_id' => null,
        ));

        Post::create(array(
            'category' => 'Showbizz/Entertainment',
            'platform' => 'Facebook',
            'caption' => "Ondanks alles wat je doormaakte liet je mij inzien dat het om één ding draait in het leven: liefhebben. Vertrouwen en je leven niet laten beheersen door angst en pijn.' #Monumentje",
            'post_url' => 'https://www.facebook.com/linda.nl/posts/10159353141418659',
            'image_url' => 'https://external-ams4-1.xx.fbcdn.net/safe_image.php?d=AQF1fWCGNVE7pDry&w=500&h=261&url=https%3A%2F%2Fwww.linda.nl%2Flindanl-assets%2Fuploads%2F2021%2F03%2F19132454%2Fthumbnail_Schermafbeelding-2019-11-01-om-12.09.32-Cropped-600x337.png&cfs=1&ext=jpg&_nc_cb=1&ccb=3-4&_nc_hash=AQFQ5gOlk8Ap9WSE',
            'engagement' => 2,
            'old_engagement' => 0,
            'writer_id' => null,
        ));

        Post::create(array(
            'category' => 'Food/Recipes',
            'platform' => 'Facebook',
            'caption' => "We moeten natuurlijk wel bij de tijd blijven 😜",
            'post_url' => 'https://www.facebook.com/24kitchen/posts/4353668574687673',
            'image_url' => 'https://external-ams4-1.xx.fbcdn.net/safe_image.php?d=AQHM8PfXk6icDUH1&w=500&h=261&url=https%3A%2F%2Fwww.24kitchen.nl%2Ffiles%2Fstyles%2Fsocial_media_share%2Fpublic%2F2020-06%2Frudolph_0.jpg%3Fitok%3DBwNjBWcY&cfs=1&sx=0&sy=0&sw=768&sh=401&ext=jpg&_nc_cb=1&ccb=3-4&_nc_hash=AQFsFut0ZVOmhpsf',
            'engagement' => 34,
            'old_engagement' => 20,
            'writer_id' => null,
        ));

        Post::create(array(
            'category' => 'Cars',
            'platform' => 'Instagram',
            'caption' => "De nieuwe Toyota Aygo is in aantocht. Met deze Aygo X Prologue geeft Toyota een interessante vooruitblik op z'n nieuwste kleintje!",
            'post_url' => 'https://www.instagram.com/p/CMhDmhlgnlt/?utm_source=ig_web_copy_link',
            'image_url' => 'https://scontent-ams4-1.cdninstagram.com/v/t51.2885-15/e35/s1080x1080/160506490_238803334650816_1740005052061460684_n.jpg?tp=1&_nc_ht=scontent-ams4-1.cdninstagram.com&_nc_cat=100&_nc_ohc=TR8nqvV1G7QAX_Vw9k7&ccb=7-4&oh=e1f5c078dca43127f793286664fcde7a&oe=607FDE3E',
            'engagement' => 492,
            'old_engagement' => 300,
            'writer_id' => null,
        ));
    }
}
