<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RomanHistorySeeder extends Seeder
{
    public function run()
    {

        $eraKingdomId = DB::table('eras')->insertGetId([
            'name' => 'Roman Kingdom (ยุคราชอาณาจักร)',
            'description' => 'ยุคเริ่มต้นของการก่อตั้งกรุงโรม ปกครองโดยกษัตริย์',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $eraRepublicId = DB::table('eras')->insertGetId([
            'name' => 'Roman Republic (ยุคสาธารณรัฐ)',
            'description' => 'ยุคที่โรมขยายอำนาจอย่างมาก ปกครองโดยวุฒิสภา',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $eraEmpireId = DB::table('eras')->insertGetId([
            'name' => 'Roman Empire (ยุคจักรวรรดิโรม)',
            'description' => 'ยุคที่โรมปกครองโดยจักรพรรดิที่ครอบคลุมทั่วยุโรป, ออเรีย, อัฟริกา',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
   
        DB::table('events')->insert([
            [
                'era_id' => $eraKingdomId,
                'title' => 'The Founding of Rome (การก่อตั้งกรุงโรม)',
                'start_year' => -753,
                'end_year' => -753,
                'location' => 'Rome',
                'key_figures' => 'Romulus, Remus',
                'description' => 'ตามตำนาน กรุงโรมก่อตั้งโดยฝาแฝดรอมิวลุสและรีมัส รอมิวลุสได้เป็นกษัตริย์องค์แรก',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'era_id' => $eraRepublicId,
                'title' => 'Assassination of Julius Caesar (การลอบสังหารจูเลียส ซีซาร์)',
                'start_year' => -44,
                'end_year' => -44,
                'location' => 'Theatre of Pompey, Rome',
                'key_figures' => 'Julius Caesar, Marcus Brutus, Cassius',
                'description' => 'ซีซาร์ถูกลอบสังหารโดยกลุ่มสมาชิกวุฒิสภาในวัน Ides of March นำไปสู่การล่มสลายของสาธารณรัฐ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'era_id' => $eraEmpireId,
                'title' => 'Augustus becomes First Emperor (ออกัสตัสขึ้นเป็นจักรพรรดิองค์แรก)',
                'start_year' => -27,
                'end_year' => 14,
                'location' => 'Roman Empire',
                'key_figures' => 'Augustus (Octavian)',
                'description' => 'ออคเตเวียนได้รับฉายา \'ออกัสตัส\' จากวุฒิสภา และรวบอำนาจไว้แต่เพียงผู้เดียว ถือเป็นการสิ้นสุดยุคสาธารณรัฐและเริ่มต้นยุคจักรวรรดิโรมันอย่างเป็นทางการ',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}