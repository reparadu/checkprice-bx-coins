<?php
        for ($i=1; $i <4 ; $i++) { 
            echo '<pre>';
            
            require_once('bitexthai.php'); // include the class file

            $url = 'https://bx.in.th/api/orderbook/?pairing=1';
            $result = @file_get_contents($url);
            $result = json_decode($result, true);

            $buy = $result['bids']['0']['0'];
            $volume = $result['bids']['0']['1']*$buy;
            if($volume>100)
                $volume=100;

            
            $bitexthai = new bitexthai('','','');
            if($orders = $bitexthai->getorders(array('type' => 'buy'))){
                
                foreach ($orders as $key => $v) {
                    if((int)$v->rate!=(int)$buy)
                    {
                        sleep(2);
                        $bitexthai = new bitexthai('','','');
                        if($bitexthai->cancel(1, $v->order_id)){ // Currency Pairing ID, Order ID
                            echo 'Order Cancel';
                        }else{
                            echo 'Failed: '.$bitexthai->msg;
                        }
                        echo '<br>';
                    }
                }
                
            }else{
                echo 'Failed: '.$bitexthai->msg;
            }

            if(isset($v)){
                if((int)$v->rate!=(int)$buy)
                {
                    echo '<br>';
                    $bitexthai = new bitexthai('','','');
                    if($bitexthai->order(1, 'buy', $volume, $buy)){  // Currency Pairing ID, Buy/Sell, Amount, Rate
                        $order_id = $bitexthai->msg;
                        echo 'Order has been placed! Order ID: '.$order_id;
                    }else{
                        echo 'Order failed: '.$bitexthai->msg;
                    }
                    echo '<br>';
                }
            } else {
                    echo '<br>';
                    $bitexthai = new bitexthai('','','');
                    if($bitexthai->order(1, 'buy', $volume, $buy)){  // Currency Pairing ID, Buy/Sell, Amount, Rate
                        $order_id = $bitexthai->msg;
                        echo 'Order has been placed! Order ID: '.$order_id;
                    }else{
                        echo 'Order failed: '.$bitexthai->msg;
                    }
            }

            sleep(12);
        }
        echo '<br>';
 ?>
