<?php


class Controller
{

    //GESTION DES REDIRECTION :
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

    protected function returnRedirect($path)
    {
        header("Location: ".$path);

        return true;
    }


    //GESTION DES SESSIONS :
    protected function setSession($label, $value)
    {
        $_SESSION[$label] = $value;
        return $_SESSION[$label];
    }

    protected function getSession($label)
    {
        return $_SESSION[$label];
    }

    protected function sessionExist($label)
    {
        if (!isset($_SESSION[$label])){
            return false;
        }
        return true;
    }
}