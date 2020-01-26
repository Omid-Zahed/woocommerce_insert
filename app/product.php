<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once __DIR__.'/Term.php';
require_once __DIR__.'/meta_data.php';
require_once __DIR__.'/object_data.php';


/**
 * Description of product
 *
 * @author omid
 */
  class product extends object_data {

            public $postType="product";
            private $tabel              =null;

            public function __construct     ($tabel="wp_posts") { 
                $this->tabel=$tabel;
            }
            public function create (
                $money,
                $post_title,
                $post_content,
                $content_min,
                $image_url,
                $arrayGallery,
                $Term_id,
                $arrayAttribute,
                $numberProduct,
                $dayIsactive=null,
                $moneyOff=null

            ){

                //creat raw product
                $tb=$this->getDB($this->tabel);
                $tb->cols=["post_title","post_content","post_excerpt","post_name","post_type"];
                $tb->insert([$post_title,$post_content,$content_min, urlencode(str_replace(" ", "-", $post_title)) ,$this->postType], TRUE);
                $post_id=$tb->LastId();



                //add meta data for product
                $meta=new meta_data();
                $_product_attributes=[];
                $index=0;
                foreach ($arrayAttribute as $Attribute){
                    $_product_attributes[]=[
                        "name" =>  $Attribute[0],
                        "value" => $Attribute[1],
                        "position" => $index,
                        "is_visible" => "1",
                        "is_variation" => "0",
                        "is_taxonomy" => "0",
                    ];
                  $index++;
                }
                $data=[
                    "_product_image_gallery"=>1,
                    "_product_image_gallery"=>1,
                    "_thumbnail_id"=>1,
                    "_price"=>$money,
                    "_low_stock_amount"=>1,
                    "_regular_price"=>$money,
                    "_stock_status"=>"instock",
                    "_stock"=>$numberProduct,
                    "_manage_stock"=>"yes",

                    "_URLproduct"=>"yes",
                    "_URLproduct_image"=>$image_url,
                    "_URLproduct_gallery"=>serialize($arrayGallery)
                ];
                if(!empty($moneyOff)){$data["_sale_price"]=$moneyOff;}
                if (!empty($dayIsactive)){
                    $timeEND=$dayIsactive*24*60*60;
                    $timeStart=time();
                    $data["_sale_price_dates_from"]=$timeStart;
                    $data["_sale_price_dates_to"]=$timeEND;
                }
                if(!empty($_product_attributes)){ $data["_product_attributes"]=serialize($_product_attributes);        }

                foreach ($data as $key => $value) {
                     $meta->insert($post_id, $key, $value);
                }

                //add Term relation
                $term=new TermRelation();
                if(is_array($Term_id))
                {
                    foreach ($Term_id as $t){
                        $term->creat($post_id,$t);
                     }
                }
                else
                {$term->creat($post_id,$Term_id);}


                return $post_id;


            }
            public function delet           ($id){
                $this->delet_item($this->tabel, $id);
            }
            public function update          ($arrayProperty){}
            public function getAll(){     return   $this->getDB($this->tabel)->select("WHERE `post_type`= ?",["product"])->fetchAll();}
            public function get($id)
            {
                $base_product=$this->getDB($this->tabel)->select("WHERE `id`= ? AND `post_type`= ? ", [$id,"product"])->fetch();
                $base_product_id=$base_product["ID"];

                $meta=new meta_data();
                $base_product=array_merge($base_product,array("meta"=>$meta->get_all_postMeta($base_product_id)));

                $TermRelation=new TermRelation();
                $base_product_TermRelation=$TermRelation->get_by_obj($base_product_id);

                $Term=new Term();
                $base_product_terms=[];
                foreach ($base_product_TermRelation as $term){
                    $base_product_terms[]=$Term->get($term["term_taxonomy_id"]);
                }
                $base_product=array_merge($base_product,array("term"=>$base_product_terms));



                return $base_product;  }


            }

            
            
            
            
            
            
//            
//      $product=new product();
// dd($product->create(
//            154000,
//            "لپ تاپ15 اینچی ایسر مدل Aspire VX5-591G-710B",
//            "لپ تاپ 15 اینچی ایسر مدل Aspire VX5-591G-710B",
//            "ایسر لپ‌تاپ مخصوص بازی جدید خود را معرفی کرد. ایسر اسپایر VX5-591G با ویژگی‌های سخت‌افزاری جدید و قوی به بازار عرضه شده است. این لپ‌تاپ شبیه مدل‌های قدیمی‌تر Predator است و از رنگ مشکی و قرمز در آن استفاده شده است. بدنه‌ی این لپ‌تاپ پلاستیکی است و لوگوی ایسر با رنگ نقره‌ای در میانه‌ی قاب پشتی صفحه‌نمایش به‌چشم می‌خورد. قطعاتی از پشت و جلوی دستگاه، به‌همراه دکمه‌های WASD و نور پس‌زمینه‌ی کیبورد قرمزرنگ هستند و کاملا حس یک لپ‌تاپ خشن و مخصوص بازی را القا می‌کند. پردازنده‌ی مرکزی این دستگاه جدیدترین مدل پردازنده‌های نسل هفتم یعنی 7700HQ است که فرکانس کاری آن از ۲.۸ گیگاهرتز آغاز می‌شود و هنگام پردازش‌های سنگین با استفاده از فناوری Turbo Boost تا ۳.۸ گیگاهرتز می‌رسد. این قدرت برای اجرای برنامه‌های سنگین و بازی مناسب است و تقریبا از پس هر کاری برمی‌آید. حافظه‌ی رم آن ۱۶ گیگابایت از نوع DDR4 و حافظه‌ی داخلی آن متشکل از یک ترابایت هارددیسک است و فضای کافی برای نصب بازی‌ها و ذخیره‌ی فایل‌ها را در اختیار کاربر می‌گذارد. پردازنده‌ی گرافیکی این دستگاه ساخت شرکت NVIDIA با مدل GeForce GTX 1050 است که چهار گیگابایت حافظه‌ی اختصاصی را در اختیار کاربر قرار می‌دهد تا برای اجرای بازی‌ها با تنظیمات گرافیکی متوسط و بالا مشکلی نداشته باشد. صفحه‌نمایش ۱۵.۶اینچی با پنل IPS و کیفیت تصویر Full HD تصاویر خوب و قابل‌قبولی را ارائه می‌کند. روکش مات هم برای بازی‌کردن و فیلم‌دیدن و کار با لپ‌تاپ در محیط‌های پرنور بسیار خوب است و چشم را اذیت نمی‌کند. پورت‌های این دستگاه هم کامل است و همه‌ی پورت‌های لازم برای آن در نظر گرفته شده است. تنها پورتی که دیده نمی‌شود، VGA است که با توجه به دستگاه‌های جدید، دیگر خیلی از آن استفاده نمی‌شود. باتری ایسر VX5-591G یک باتری سه‌سلولی است که به گفته‌ی شرکت سازنده تا شش ساعت شارژدهی دارد که مسلما این مقدار هنگام کارهای سنگین و بازی کمتر خواهد شد. این لپ‌تاپ محصولی جدید با پردازنده‌ی جدید است که احتمالا طرفداران زیادی خواهد داشت.",
//            "https://dkstatics-public.digikala.com/digikala-products/1204692.jpg?x-oss-process=image/resize,h_1600/quality,q_80",
//            ["https://dkstatics-public.digikala.com/digikala-products/1204939.jpg?x-oss-process=image/resize,h_1600/quality,q_80",
//                "https://docs.moodle.org/dev/skins/moodledocs/sitebar/pix/logo.png",
//                "https://dkstatics-public.digikala.com/digikala-products/1205194.jpg?x-oss-process=image/resize,h_1600/quality,q_80",
//                "https://dkstatics-public.digikala.com/digikala-products/1205260.jpg?x-oss-process=image/resize,h_1600/quality,q_80"],
//            [39],
//            [["ویژگی ۱","قرمز"],["ویژگی ۲ ","۱ کیلو "]],
//            "39"
//            ));   