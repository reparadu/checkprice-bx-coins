  echo '<pre>';
        $url    = 'https://quote.coins.ph/v1/markets';
        $result = file_get_contents($url);
        $rate = json_decode($result, true);

        foreach ($rate['markets'] as $key => $v) {
            if ($v['currency'] == "THB") 
            {

                $buyCoins = ($v['ask']*1.01);
                echo '<b>coins.co.th:</b><br>';
                echo 'BUY : '.($v['ask']).' + 1% = '.($v['ask']*1.01).' THB<br>';
                echo 'SELL : '.$v['bid'].' THB<br>';
                echo '<hr>';
                


                
                break;
            }
        }


        $url = 'https://bx.in.th/api/orderbook/?pairing=1';

        $result = @file_get_contents($url);
        $result = json_decode($result, true);

        $sellBX = $result['asks']['0']['0']*(1-0.0025);
        $buyBX = $result['bids']['0']['0']*1.0025;
        echo '<b>bx.in.th:</b><br>';
        echo 'BUY : '.($result['bids']['0']['0']).' + 0.25% = '.($result['bids']['0']['0']*1.0025).' THB<br>';
        echo 'Volume: '.$result['bids']['0']['1'].'<br>';
        echo 'SELL : '.($result['asks']['0']['0']).' - 0.25% = '.($result['asks']['0']['0']*(1-0.0025)).' THB<br>';
        echo 'Volume: '.$result['asks']['0']['1'].'<br>';
        echo '<hr>';
        echo 'BUY BID(BX) : '.($result['asks']['0']['0']).' + 0.25% = '.($result['asks']['0']['0']*(1+0.0025)).' THB<br>';
        echo '<hr>';
        echo 'Buy Coins(+1%) Sell Bx(-0.25%) = '.($sellBX - $buyCoins). 'THB<br>';
        echo 'Buy Bx(+0.25%) Sell Bx(-0.25%) = '.($sellBX - $buyBX). 'THB<br>';
        echo '<hr>';
        echo 'Statistic : '.date('Y-m-d H:i:s').'<br>';
