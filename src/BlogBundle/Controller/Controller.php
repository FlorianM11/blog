<?php


class Controller
{
    protected function returnJson(Article $article, Users $users)
    {
        $userArray = (array)$users;
        $articleArray = (array)$article;

        foreach ($userArray as $key => $value){
            $newUserArray[str_replace("\x00Users\x00_", "", $key)] = $value;
        }

        foreach ($articleArray as $key => $value){
            $newArticleArray[str_replace("\x00Article\x00_", "", $key)] = $value;
        }

        $newArticleArray['author'] = $newUserArray;

        return json_encode($newArticleArray);
    }
}