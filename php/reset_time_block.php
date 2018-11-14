<?php
date_default_timezone_set('PRC');
$mode = $_POST['mode'];
$time_block = $_POST['block'];
for ($i = 0; $i < count($time_block); $i++) {
    for ($j = 0; $j < count($time_block[$i]); $j++) {
        if ($mode == 0) {
            $tm_tm = $time_block[$i][$j]['time'];
            $str_tm = date('Y-m-d H:i',$tm_tm);
            $al = (time() > $tm_tm+(60*25)) ? 0 : 1;//目前时间比时间块时间大25分钟，则时间块无法选择(时间块里面最多细分到超前25分钟)
        } else {
            $al = 1;
        }
        $time_block[$i][$j]['allow'] = $al;
        $time_block[$i][$j]['choosen'] = 0;
        // Vue.set(
        //     $time_block[$i],
        //     $j, {
        //         time: $time_block[$i][$j].time,
        //         choosen: 0,
        //         allow: al
        //     }
        // )
    }
}
echo json_encode(['block'=>$time_block]);