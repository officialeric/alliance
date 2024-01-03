<?php

class Drop extends User  //Post
{
    protected $message;

    public function __construct($pdo){
        $this->pdo = $pdo;
        $this->message  = new Message($this->pdo);
    }

    public function drops($user_id, $num){
        $stmt = $this->pdo->prepare("SELECT * FROM `drops` LEFT JOIN `users` ON `dropBy` = `user_id` WHERE `dropBy` = :user_id AND `redropID` = '0' OR `dropBy` = `user_id` AND `redropBy` != :user_id AND `dropBy` IN (SELECT `receiver` FROM `follow` WHERE `sender` =:user_id) ORDER BY `dropID` DESC LIMIT :num");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":num", $num, PDO::PARAM_INT);
        $stmt->execute();
        $drops = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($drops as $drop) {
            $likes = $this->likes($user_id, $drop->dropID);
            $redrop = $this->checkRedrop($drop->dropID, $user_id);
            $user = $this->userData($drop->redropBy);
            echo '<div class="all-drop">
			      <div class="t-show-wrap">
			       <div class="t-show-inner">
			       '.((isset($redrop['redropID']) ? $redrop['redropID'] === $drop->redropID OR $drop->redropID > 0 : '') ? '
			      	<div class="t-show-banner">
			      		<div class="t-show-banner-inner">
			      			<span><i class="fa fa-redrop" aria-hidden="true"></i></span><span>'.$user->username.' Redroped</span>
			      		</div>
			      	</div>'
                    : '').'

			        '.((!empty($drop->redropMsg) && $drop->dropID === $redrop['dropID'] or $drop->redropID > 0) ? '<div class="t-show-head">
			        <div class="t-show-popup" data-drop="'.$drop->dropID.'">
			          <div class="t-show-img">
			        		<img src="'.BASE_URL.$user->profileImage.'"/>
			        	</div>
			        	<div class="t-s-head-content">
			        		<div class="t-h-c-name">
			        			<span><a href="'.BASE_URL.$user->username.'">'.$user->username.'</a></span>
			        			<span>@'.$user->username.'</span>
			        			<span>'.$this->timeAgo($drop->postedOn).'</span>

			        		</div>
			        		<div class="t-h-c-dis">
			        			'.$this->getdropLinks($drop->redropMsg).'
			        		</div>
			        	</div>
			        </div>
			        <div class="t-s-b-inner">
			        	<div class="t-s-b-inner-in">
			        		<div class="redrop-t-s-b-inner">
			            '.((!empty($drop->dropImage)) ? '
			        			<div class="redrop-t-s-b-inner-left">
			        				<img src="'.BASE_URL.$drop->dropImage.'" class="imagePopup" data-drop="'.$drop->dropID.'"/>
			        			</div>' : '').'
			        			<div>
			        				<div class="t-h-c-name">
			        					<span><a href="'.BASE_URL.$drop->username.'">'.$drop->username.'</a></span>
			        					<span>@'.$drop->username.'</span>
			        					<span>'.$this->timeAgo($drop->postedOn).'</span>
			        				</div>
			        				<div class="redrop-t-s-b-inner-right-text">
			        					'.$this->getdropLinks($drop->status).'
			        				</div>
			        			</div>
			        		</div>
			        	</div>
			        </div>
			        </div>' : '

			      	<div class="t-show-popup" data-drop="'.$drop->dropID.'">
			      		<div class="t-show-head">
			      			<div class="t-show-img">
			      				<img src="'.$drop->profileImage.'"/>
			      			</div>
			      			<div class="t-s-head-content ">
			      				<div class="t-h-c-name media-body">
			      					<span><a href="'.$drop->username.'">'.$drop->username.'</a></span>
			      					<span>@'.$drop->username.'</span>
			      					<span>'.$this->timeAgo($drop->postedOn).'</span>
			      				</div>
			      				<div class="t-h-c-dis">
			      					'.$this->getdropLinks($drop->status).'
			      				</div>
			      			</div>
			      		</div>'.
                    ((!empty($drop->dropImage)) ?
                        '<!--drop show head end-->
			            		<div class="t-show-body">
			            		  <div class="t-s-b-inner">
			            		   <div class="t-s-b-inner-in">
			            		     <img src="'.$drop->dropImage.'" class="imagePopup" data-drop="'.$drop->dropID.'"/>
			            		   </div>
			            		  </div>
			            		</div>
			            		<!--drop show body end-->
			          ' : '').'

			      	</div>').'
			      	<div class="t-show-footer">
			      		<div class="t-s-f-right">
			      			<ul>
			      				<li><button style="outline:none;"><i class="fa fa-comment" aria-hidden="true"></i></button></li>
			      				<li>'.((isset($redrop['redropID']) ? $drop->dropID === $redrop['redropID'] : '') ?
                    '<button class="redroped" data-drop="'.$drop->dropID.'" data-user="'.$drop->dropBy.'" style="outline:none;"><i class="fa fa-redrop" aria-hidden="true" style="outline:none;"></i><span class="redropsCount">'.(($drop->redropCount > 0) ? $drop->redropCount : '').'</span></button>' :
                    '<button class="redrop" data-drop="'.$drop->dropID.'" data-user="'.$drop->dropBy.'" style="outline:none;"><i class="fa fa-redrop" aria-hidden="true"></i><span class="redropsCount">'.(($drop->redropCount > 0) ? $drop->redropCount : '').'</span></button>').'
			      				</li>
			      				<li>'.((isset($likes['likeOn']) ? $likes['likeOn'] === $drop->dropID : '') ?
                    '<button class="unlike-btn" data-drop="'.$drop->dropID.'" data-user="'.$drop->dropBy.'" style="outline:none;"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.(($drop->likesCount > 0) ? $drop->likesCount : '' ).'</span></button>' :
                    '<button class="like-btn" data-drop="'.$drop->dropID.'" data-user="'.$drop->dropBy.'" style="outline:none;"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($drop->likesCount > 0) ? $drop->likesCount : '' ).'</span></button>').'
			      				</li>
			               
			                '.(($drop->dropBy === $user_id) ? '
			              	    <li>
			      					<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true" style="outline:none;"></i></a>
			      					<ul>
			      					  <li><label class="deletedrop" data-drop="'.$drop->dropID.'">Delete drop</label></li>
			      					</ul>
			      				</li>' : '').'

			      			</ul>
			      		</div>
			      	</div>
			      </div>
			      </div>
			      </div>';
        }
    }

    public function getUserdrops($user_id){
        $stmt = $this->pdo->prepare("SELECT * FROM `drops` LEFT JOIN `users` ON `dropBy` = `user_id` WHERE `dropBy` = :user_id AND `redropID` = '0' OR `redropBy` = :user_id ORDER BY `dropID` DESC");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addLike($user_id, $drop_id, $get_id){
        $stmt = $this->pdo->prepare("UPDATE `drops` SET `likesCount` = `likesCount`+1 WHERE `dropID` = :drop_id");
        $stmt->bindParam(":drop_id", $drop_id, PDO::PARAM_INT);
        $stmt->execute();

        $this->create('likes', array('likeBy' => $user_id, 'likeOn' => $drop_id));

        if($get_id != $user_id){
            $this->message->sendNotification($get_id, $user_id, $drop_id, 'like');
        }
    }

    public function unLike($user_id, $drop_id, $get_id){
        $stmt = $this->pdo->prepare("UPDATE `drops` SET `likesCount` = `likesCount`-1 WHERE `dropID` = :drop_id");
        $stmt->bindParam(":drop_id", $drop_id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $this->pdo->prepare("DELETE FROM `likes` WHERE `likeBy` = :user_id and `likeOn` = :drop_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":drop_id", $drop_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function likes($user_id, $drop_id){
        $stmt = $this->pdo->prepare("SELECT * FROM `likes` WHERE `likeBy` = :user_id AND `likeOn` = :drop_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":drop_id", $drop_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTrendByHash($hashtag){
        $stmt = $this->pdo->prepare("SELECT * FROM `trends` WHERE `hashtag` LIKE :hashtag LIMIT 5");
        $stmt->bindValue(":hashtag", $hashtag.'%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getMension($mension){
        $stmt = $this->pdo->prepare("SELECT `user_id`,`username`,`screenName`,`profileImage` FROM `users` WHERE `username` LIKE :mension OR `screenName` LIKE :mension LIMIT 5");
        $stmt->bindValue("mension", $mension.'%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    public function addTrend($hashtag){
        preg_match_all("/#+([a-zA-Z0-9_]+)/i", $hashtag, $matches);
        if($matches){
            $result = array_values($matches[1]);
        }
        $sql = "INSERT INTO `trends` (`hashtag`, `createdOn`) VALUES (:hashtag, CURRENT_TIMESTAMP)";
        foreach ($result as $trend) {
            if($stmt = $this->pdo->prepare($sql)){
                $stmt->execute(array(':hashtag' => $trend));
            }
        }
    }

    public function addMention($status,$user_id, $drop_id){
        if(preg_match_all("/@+([a-zA-Z0-9_]+)/i", $status, $matches)){
            if($matches){
                $result = array_values($matches[1]);
            }
            $sql = "SELECT * FROM `users` WHERE `username` = :mention";
            foreach ($result as $trend) {
                if($stmt = $this->pdo->prepare($sql)){
                    $stmt->execute(array(':mention' => $trend));
                    $data = $stmt->fetch(PDO::FETCH_OBJ);
                }
            }

            if($data->user_id != $user_id){
                $this->message->sendNotification($data->user_id, $user_id, $drop_id, 'mention');
            }
        }
    }

    public function getDropLinks($drop){
        $drop = preg_replace("/(https?:\/\/)([\w]+.)([\w\.]+)/", "<a href='$0' target='_blink'>$0</a>", $drop);

        //$drop = preg_replace("/#([\w]+)/", "<a href='http://localhost/twitter/hashtag/$1'>$0</a>", $drop);		

        $drop = preg_replace("/#([\w]+)/", "<a href='http://localhost/twitter/$1'>$0</a>", $drop);

        $drop = preg_replace("/@([\w]+)/", "<a href='http://localhost/twitter/$1'>$0</a>", $drop);
        return $drop;
    }

    public function getPopupDrop($drop_id){
        $stmt = $this->pdo->prepare("SELECT * FROM `drops`,`users` WHERE `dropID` = :drop_id AND `dropBy` = `user_id`");
        $stmt->bindParam(":drop_id", $drop_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function reDrop($drop_id, $user_id, $get_id, $comment){
        $stmt = $this->pdo->prepare("UPDATE `drops` SET `redropCount` = `redropCount`+1 WHERE `dropID` = :drop_id AND `dropBy` = :get_id");
        $stmt->bindParam(":drop_id", $drop_id, PDO::PARAM_INT);
        $stmt->bindParam(":get_id", $get_id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $this->pdo->prepare("INSERT INTO `drops` (`status`,`dropBy`,`redropID`,`redropBy`,`dropImage`,`postedOn`,`likesCount`,`redropCount`,`redropMsg`) SELECT `status`,`dropBy`,`dropID`,:user_id,`dropImage`,`postedOn`,`likesCount`,`redropCount`,:redropMsg FROM `drops` WHERE `dropID` = :drop_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":redropMsg", $comment, PDO::PARAM_STR);
        $stmt->bindParam(":drop_id", $drop_id, PDO::PARAM_INT);
        $stmt->execute();

        $this->message->sendNotification($get_id, $user_id, $drop_id, 'redrop');

    }

    public function checkReDrop($drop_id, $user_id){
        $stmt = $this->pdo->prepare("SELECT * FROM `drops` WHERE `redropID` = :drop_id AND `redropBy` = :user_id or `dropID` = :drop_id and `redropBy` = :user_id");
        $stmt->bindParam(":drop_id", $drop_id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function dropPopup($drop_id){
        $stmt = $this->pdo->prepare("SELECT * FROM `drops`,`users` WHERE `dropID` = :drop_id and `user_id` = `dropBy`");
        $stmt->bindParam(":drop_id", $drop_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function comments($drop_id){
        $stmt = $this->pdo->prepare("SELECT * FROM `comments` LEFT JOIN `users` ON `commentBy` = `user_id` WHERE `commentOn` = :drop_id");
        $stmt->bindParam(":drop_id", $drop_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function countDrops($user_id){
        $stmt = $this->pdo->prepare("SELECT COUNT(`dropID`) AS `totaldrops` FROM `drops` WHERE `dropBy` = :user_id AND `redropID` = '0' OR `redropBy` = :user_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_OBJ);
        echo $count->totaldrops;
    }

    public function countLikes($user_id){
        $stmt = $this->pdo->prepare("SELECT COUNT(`likeID`) AS `totalLikes` FROM `likes` WHERE `likeBy` = :user_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_OBJ);
        echo $count->totalLikes;
    }

    public function trends(){
        $stmt = $this->pdo->prepare("SELECT *, COUNT(`dropID`) AS `dropsCount` FROM `trends` INNER JOIN `drops` ON `status` LIKE CONCAT('%#',`hashtag`,'%') OR `redropMsg` LIKE CONCAT('%#',`hashtag`,'%') GROUP BY `hashtag` ORDER BY `dropID` LIMIT 2");
        $stmt->execute();
        $trends = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo '<div class="trends_container"><div class="trends_box"><div class="trends_header"><p>Trends for you</p></div><!-- trend title end-->';
        foreach ($trends as $trend) {
            echo '<div class="trends_body">
					<div class="trend">
                    <span>Trending</span>
						<p>
							<a style="color: #000;">#'.$trend->hashtag.'</a>
						</p>
						<div class="trend-drops">
							
						</div>
					</div>
                </div>
                <div>
				</div>';
        }
        echo '<div class="trends_show-more">
                    <a href="">Show more</a>
                </div></div></div>';
    }

    public function getDropsByHash($hashtag){
        $stmt = $this->pdo->prepare("SELECT * FROM `drops` LEFT JOIN `users` ON `dropBy` = `user_id` WHERE `status` LIKE :hashtag OR `redropMsg` LIKE :hashtag");
        $stmt->bindValue(":hashtag", '%#'.$hashtag.'%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUsersByHash($hashtag){
        $stmt = $this->pdo->prepare("SELECT DISTINCT * FROM `drops` INNER JOIN `users` ON `dropBy` = `user_id` WHERE `status` LIKE :hashtag OR `redropMsg` LIKE :hashtag GROUP BY `user_id`");
        $stmt->bindValue(":hashtag", '%#'.$hashtag.'%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}