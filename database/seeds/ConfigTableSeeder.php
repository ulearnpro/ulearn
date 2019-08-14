<?php

use Illuminate\Database\Seeder;
use App\Models\Config;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $is_exist = Config::all();

        if (!$is_exist->count()) {
            Config::create( [
            'id'=>1,
            'code'=>'pageHome',
            'option_key'=>'banner_title',
            'option_value'=>'Learn courses online'
            ] );
                        
            Config::create( [
            'id'=>2,
            'code'=>'pageHome',
            'option_key'=>'banner_text',
            'option_value'=>'Learn every topic. On time. Everytime.'
            ] );
                        
            Config::create( [
            'id'=>3,
            'code'=>'pageHome',
            'option_key'=>'instructor_text',
            'option_value'=>'We have more than 3,250 skilled & professional Instructors'
            ] );
                        
            Config::create( [
            'id'=>4,
            'code'=>'pageHome',
            'option_key'=>'learn_block_title',
            'option_value'=>'Learn every topic, everytime.'
            ] );
                        
            Config::create( [
            'id'=>5,
            'code'=>'pageHome',
            'option_key'=>'learn_block_text',
            'option_value'=>'
            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.'
            ] );

                        
            Config::create( [
            'id'=>6,
            'code'=>'pageAbout',
            'option_key'=>'content',
            'option_value'=>'<article class="container">
            <div class="row">
                <div class="col-12">
                   <h5 class="mt-3 underline-heading">OUR MISSION IS SIMPLE</h5>
                   <p>Cobem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla dolor sit amet, consectetuer adipiscing elit. </p>
                   <p> Aenean commodo ligula eget dolor. Aenean massa. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, eta rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis. Lorem ipsum dolor sit amet,Aenean commodo ligula eget dolor. Aenean massa. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, eta rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis. Lorem ipsum dolor sit amet,</p>

                   <ul class="ul-no-padding about-ul">
                        <li>Commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.Commodo ligula eget dolor. Aenean massa. Port sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</li>
                        <li>Dum sociis natoque penatibus et magnis dis parturient montes</li>
                        <li>Nascetur ridiculus mus, Nulla consequat massa quis enim, Cum sociis natoque penatibus et magnis dis parturient montes</li>
                        <li>Commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.Commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</li>
                        <li>Nascetur ridiculus mus, Nulla consequat massa quis enim  </li>
                        <li>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus, Nulla consequat massa quis enim </li>
                        <li>Consectetuer adipiscing elit. Aenean commodo ligula eget dolor</li>
                        
                    </ul>
                </div>
            </div>
        </article><article class="count-block jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                    <h3 class="underline-heading">150</h3>
                    <h6>COUNTRIES REACHED</h6>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                    <h3 class="underline-heading">850</h3>
                    <h6>COUNTRIES REACHED</h6>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                    <h3 class="underline-heading">38300</h3>
                    <h6>PASSED GRADUATES</h6>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                    <h3 class="underline-heading">3400</h3>
                    <h6>COURSES PUBLISHED</h6>
                </div>
            </div>
        </div>
    </article><article class="about-features-block">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center seperator-head mt-3">
                <h3>Why choose Ulearn</h3>
                <p class="mt-3">Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
            </div>
        </div>
                        <div class="row mt-4 mb-5">
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="feature-box mx-auto text-center">
                    <main>
                        <i class="fas fa-file-signature"></i>
                        <div class="col-md-12">
                            <h6 class="instructor-title">Hi-Tech Learning </h6>
                            <p>Aenean massa. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </p>
                        </div>
                    </main>
                </div>
            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="feature-box mx-auto text-center">
                    <main>
                        <i class="fas fa-users-cog"></i>
                        <div class="col-md-12">
                            <h6 class="instructor-title">Course Discussion </h6>
                            <p>Aenean massa. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </p>
                        </div>
                    </main>
                </div>
            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="feature-box mx-auto text-center">
                    <main>
                        <i class="fas fa-shield-alt"></i>
                        <div class="col-md-12">
                            <h6 class="instructor-title">Website Security </h6>
                            <p>Aenean massa. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </p>
                        </div>
                    </main>
                </div>
            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="feature-box mx-auto text-center">
                    <main>
                        <i class="fas fa-chalkboard-teacher"></i>
                        <div class="col-md-12">
                            <h6 class="instructor-title">Qualified teachers </h6>
                            <p>Aenean massa. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </p>
                        </div>
                    </main>
                </div>
            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="feature-box mx-auto text-center">
                    <main>
                        <i class="fas fa-building"></i>
                        <div class="col-md-12">
                            <h6 class="instructor-title">Equiped class rooms </h6>
                            <p>Aenean massa. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </p>
                        </div>
                    </main>
                </div>
            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="feature-box mx-auto text-center">
                    <main>
                        <i class="fas fa-digital-tachograph"></i>
                        <div class="col-md-12">
                            <h6 class="instructor-title">Advanced teaching </h6>
                            <p>Aenean massa. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </p>
                        </div>
                    </main>
                </div>
            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="feature-box mx-auto text-center">
                    <main>
                        <i class="fas fa-puzzle-piece"></i>
                        <div class="col-md-12">
                            <h6 class="instructor-title">Adavanced study plans </h6>
                            <p>Aenean massa. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </p>
                        </div>
                    </main>
                </div>
            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="feature-box mx-auto text-center">
                    <main>
                        <i class="fas fa-bullseye"></i>
                        <div class="col-md-12">
                            <h6 class="instructor-title">Focus on target </h6>
                            <p>Aenean massa. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </p>
                        </div>
                    </main>
                </div>
            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="feature-box mx-auto text-center">
                    <main>
                        <i class="fas fa-thumbs-up"></i>
                        <div class="col-md-12">
                            <h6 class="instructor-title">Focus on success </h6>
                            <p>Aenean massa. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </p>
                        </div>
                    </main>
                </div>
            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="feature-box mx-auto text-center">
                    <main>
                        <i class="fas fa-tablet-alt"></i>
                        <div class="col-md-12">
                            <h6 class="instructor-title">Responsive Design </h6>
                            <p>Aenean massa. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </p>
                        </div>
                    </main>
                </div>
            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="feature-box mx-auto text-center">
                    <main>
                        <i class="fas fa-credit-card"></i>
                        <div class="col-md-12">
                            <h6 class="instructor-title">Payment Gateways </h6>
                            <p>Aenean massa. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </p>
                        </div>
                    </main>
                </div>
            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="feature-box mx-auto text-center">
                    <main>
                        <i class="fas fa-search-plus"></i>
                        <div class="col-md-12">
                            <h6 class="instructor-title">SEO Friendly </h6>
                            <p>Aenean massa. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </p>
                        </div>
                    </main>
                </div>
            </div>
                        </div>
    </div>
</article>'
            ] );

                        
            Config::create( [
            'id'=>7,
            'code'=>'pageContact',
            'option_key'=>'telephone',
            'option_value'=>'+61 (800) 123-54323'
            ] );
                        
            Config::create( [
            'id'=>8,
            'code'=>'pageContact',
            'option_key'=>'email',
            'option_value'=>'XYZ@example.com'
            ] );
                        
            Config::create( [
            'id'=>9,
            'code'=>'pageContact',
            'option_key'=>'address',
            'option_value'=>'8432 Newyork United States'
            ] );
                        
            Config::create( [
            'id'=>10,
            'code'=>'pageContact',
            'option_key'=>'map',
            'option_value'=>'<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.940622898076!2d-74.00543578509465!3d40.74133204375838!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259bf14f1f51f%3A0xcc1b5ab35bd75df0!2sGoogle!5e0!3m2!1sen!2sin!4v1542693598934" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>'
            ] );
                        
            Config::create( [
            'id'=>11,
            'code'=>'settingGeneral',
            'option_key'=>'application_name',
            'option_value'=>'Ulearn'
            ] );
                        
            Config::create( [
            'id'=>12,
            'code'=>'settingGeneral',
            'option_key'=>'meta_key',
            'option_value'=>'Learn courses online'
            ] );
                        
            Config::create( [
            'id'=>13,
            'code'=>'settingGeneral',
            'option_key'=>'meta_description',
            'option_value'=>'Learn every topic. On time. Every time.'
            ] );
                        
            Config::create( [
            'id'=>14,
            'code'=>'settingGeneral',
            'option_key'=>'admin_commission',
            'option_value'=>'20'
            ] );

            Config::create( [
                'id'=>15,
                'code'=>'settingGeneral',
                'option_key'=>'admin_email',
                'option_value'=>'admin@ulearn.com'
                ] );
                        
            Config::create( [
            'id'=>16,
            'code'=>'settingGeneral',
            'option_key'=>'minimum_withdraw',
            'option_value'=>'100'
            ] );
                        
            Config::create( [
            'id'=>17,
            'code'=>'settingGeneral',
            'option_key'=>'header_logo',
            'option_value'=>'config/logo.png'
            ] );
                        
            Config::create( [
            'id'=>18,
            'code'=>'settingGeneral',
            'option_key'=>'fav_icon',
            'option_value'=>'config/favicon.ico'
            ] );
                        
            Config::create( [
            'id'=>19,
            'code'=>'settingGeneral',
            'option_key'=>'footer_logo',
            'option_value'=>'config/logo_footer.png'
            ] );
                        
            Config::create( [
            'id'=>20,
            'code'=>'settingPayment',
            'option_key'=>'username',
            'option_value'=>''
            ] );
                        
            Config::create( [
            'id'=>21,
            'code'=>'settingPayment',
            'option_key'=>'password',
            'option_value'=>''
            ] );
                        
            Config::create( [
            'id'=>22,
            'code'=>'settingPayment',
            'option_key'=>'signature',
            'option_value'=>''
            ] );
                        
            Config::create( [
            'id'=>23,
            'code'=>'settingPayment',
            'option_key'=>'test_mode',
            'option_value'=>'1'
            ] );
                        
            Config::create( [
            'id'=>24,
            'code'=>'settingPayment',
            'option_key'=>'is_active',
            'option_value'=>'1'
            ] );
                        
            Config::create( [
            'id'=>25,
            'code'=>'settingEmail',
            'option_key'=>'smtp_host',
            'option_value'=>NULL
            ] );
                        
            Config::create( [
            'id'=>26,
            'code'=>'settingEmail',
            'option_key'=>'smtp_port',
            'option_value'=>NULL
            ] );
                        
            Config::create( [
            'id'=>27,
            'code'=>'settingEmail',
            'option_key'=>'smtp_secure',
            'option_value'=>NULL
            ] );
                        
            Config::create( [
            'id'=>28,
            'code'=>'settingEmail',
            'option_key'=>'smtp_username',
            'option_value'=>NULL
            ] );
                        
            Config::create( [
            'id'=>29,
            'code'=>'settingEmail',
            'option_key'=>'smtp_password',
            'option_value'=>NULL
            ] );

        }
    }
}
