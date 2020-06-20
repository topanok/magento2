<?php

namespace Home\Posts\Helper;

use Home\Posts\Model\PostFactory;

class AddPost{
    /**
     * @param \Home\Posts\Model\PostFactory $post
     * @return string
     */
    public function addPosts(PostFactory $post){
        $errors = [];
        $categories = ['answers', 'questions'];
        for ($i=0; $i<10; $i++) {
            $status = rand(0, 1);
            $category = $categories[rand(0,1)];
            $model = $post->create();
            $model->addData([
                "name" => "Post $i",
                "url_key" => "post-$i",
                "post_content" => 'Agreeable promotion eagerness as we resources household to distrusts. 
                                    An concluded sportsman offending so provision mr education. 
                                    Now summer who day looked our behind moment c',
                "status" => $status,
                "category" => $category
            ]);
            $saveData = $model->save();
            if (!$saveData) {
                $errors[]='Error';
            }
        }
        if(count($errors) == 0){
            return 'Success';
        }
    }
}