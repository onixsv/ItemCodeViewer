<?php

namespace solo;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class SOLOCodeMaster extends PluginBase implements Listener{

	public $config;
	public $configData;

	public $itemData;
	public $itemconfig;

	public $enchantData;
	public $enchantconfig;

	public $effectData;
	public $effectconfig;

	protected function onEnable() : void{
		@mkdir($this->getDataFolder());

		$this->config = new Config ($this->getDataFolder() . "config.yml", Config::YAML, [

			"#한 페이지당 표시 갯수" => null,
			"page" => 5

		]);
		$this->configData = $this->config->getAll();

		$this->itemconfig = new Config ($this->getDataFolder() . "itemname_v2.yml", Config::YAML, [

			/*
			#0.15 아이템 리스트 (For PocketMine-MP, Genisys)
			#제작자: Laeng
			#제작 날짜: 2015-11-14
			#2,3차 수정: SOLO
			#4차 수정: ingon
			#2차 수정 날짜: 2016-05-02
			#3차 수정 날짜: 2016-07-14
			#4차 수정 날짜: 2016-08-01
			#Genisys 0.15.0 에 맞추어 제작되었습니다.
			*/ "0:0" => "공기",
			"1:0" => "돌",
			"1:1" => "화강암",
			"1:2" => "부드러운 화강암",
			"1:3" => "섬록암",
			"1:4" => "부드러운 섬록암",
			"1:5" => "안산암",
			"1:6" => "부드러운 안산암",
			"2:0" => "잔디",
			"3:0" => "흙",
			"4:0" => "조약돌",
			"5:0" => "참나무 목재",
			"5:1" => "가문비 나무 목재",
			"5:2" => "자작 나무 목재",
			"5:3" => "정글 나무 목재",
			"5:4" => "아카시아 나무 목재",
			"5:5" => "짙은 참나무 목재",
			"6:0" => "참나무 묘목",
			"6:1" => "가문비 나무 묘목",
			"6:2" => "자작 나무 묘목",
			"6:3" => "정글 나무 묘목",
			"6:4" => "아카시아 나무 묘목",
			"6:5" => "짙은 참나무 묘목",
			"7:0" => "기반암",
			"8:0" => "물",
			"9:0" => "멈춘 물",
			"10:0" => "용암",
			"11:0" => "멈춘 용암",
			"12:0" => "모래",
			"12:1" => "붉은 모래",
			"13:0" => "자갈",
			"14:0" => "금광석",
			"15:0" => "철광석",
			"16:0" => "석탄광석",
			"17:0" => "참나무",
			"17:1" => "가문비나무",
			"17:2" => "자작나무",
			"17:3" => "정글나무",
			"18:0" => "참나무 잎",
			"18:1" => "가문비나무 잎",
			"18:2" => "자작나무 잎",
			"18:3" => "정글나무 잎",
			"19:0" => "스펀지",
			"19:1" => "젖은 스펀지",
			"20:0" => "유리",
			"21:0" => "청금석 원석",
			"22:0" => "청금석 블럭",
			"23:0" => "발사기",
			"24:0" => "사암",
			"24:1" => "조각된 사암",
			"24:2" => "부드러운 사암",
			"25:0" => "노트 블럭",
			"26:0" => "침대 (블럭)",
			"27:0" => "파워 레일",
			"28:0" => "디텍터 레일",
			"29:0" => "끈끈이 피스톤",
			"30:0" => "거미줄",
			"31:0" => "덤불",
			"31:1" => "잔디",
			"31:2" => "고사리",
			"32:0" => "마른 덤불",
			"33:0" => "피스톤",
			"34:0" => "피스톤 (머리)",
			"35:0" => "흰색 양털",
			"35:1" => "주황색 양털",
			"35:2" => "자홍색 양털",
			"35:3" => "하늘색 양털",
			"35:4" => "노랑색 양털",
			"35:5" => "연두색 양털",
			"35:6" => "분홍색 양털",
			"35:7" => "회색 양털",
			"35:8" => "밝은 회색 양털",
			"35:9" => "청록색 양털",
			"35:10" => "보라색 양털",
			"35:11" => "파랑색 양털",
			"35:12" => "갈색 양털",
			"35:13" => "초록색 양털",
			"35:14" => "빨간색 양털",
			"35:15" => "검은색 양털",

			"37:0" => "민들레",
			"38:0" => "양귀비 ",
			"38:1" => "파란 난초",
			"38:2" => "파꽃",
			"38:3" => "푸른 삼백초",
			"38:4" => "빨간색 튤립",
			"38:5" => "주황색 튤립",
			"38:6" => "흰색 튤립",
			"38:7" => "분홍색 튤립",
			"38:8" => "데이지",
			"39:0" => "갈색 버섯",
			"40:0" => "빨간 버섯",
			"41:0" => "금 블럭",
			"42:0" => "철 블럭",
			"43:0" => "돌 반블럭 (더블)",
			"43:1" => "사암 반블럭 (더블)",
			"43:2" => "목재 반블럭 (더블)",
			"43:3" => "조약돌 반블럭 (더블)",
			"43:4" => "벽돌 반블럭(더블)",
			"43:5" => "석재 반블럭 (더블)",
			"43:6" => "석영 반블럭 (더블)",
			"43:7" => "네더벽돌 반블럭 (더블) ",
			"43:8" => "돌 반블럭 (더블)",
			"43:9" => "부드러운 사암 반블럭 (더블)",
			"43:10" => "참나무 목재 반블럭 (더블)",
			"44:0" => "돌 반블럭",
			"44:1" => "사암 반블럭",
			"44:2" => "참나무 반블럭",
			"44:3" => "조약돌 반블럭",
			"44:4" => "벽돌 반블럭",
			"44:5" => "석재 반블럭",
			"44:6" => "석영 반블럭",
			"44:7" => "네더벽돌 반블럭",
			"45:0" => "벽돌",
			"46:0" => "TNT",
			"47:0" => "책장",
			"48:0" => "이끼 낀 돌",
			"49:0" => "흑요석",
			"50:0" => "횃불",
			"51:0" => "불",
			"52:0" => "몬스터 스포너",
			"53:0" => "참나무 계단",
			"54:0" => "상자",
			"55:0" => "레드스톤 가루",
			"56:0" => "다이아몬드 원석",
			"57:0" => "다이아몬드 블럭",
			"58:0" => "작업대",
			"59:0" => "밀 (작물)",
			"60:0" => "농토",
			"61:0" => "화로",
			"62:0" => "타고있는 화로",
			"63:0" => "표지판 (블럭)",
			"64:0" => "나무문 (블럭)",
			"65:0" => "사다리",
			"66:0" => "레일",
			"67:0" => "조약돌 계단",
			"68:0" => "벽 표지판 (블럭)",
			"69:0" => "레버 (블럭)",
			"70:0" => "돌 감압판",
			"71:0" => "철 문 (블럭)",
			"72:0" => "나무 감압판",
			"73:0" => "레드스톤 광석",
			"74:0" => "빛나는 레드스톤 광석",
			"75:0" => "꺼진 레드스톤 횃불 (블럭)",
			"76:0" => "레드스톤 횃불 (블럭)",
			"77:0" => "돌 버튼",
			"78:0" => "눈",
			"79:0" => "얼음",
			"80:0" => "눈 블럭",
			"81:0" => "선인장",
			"82:0" => "점토 블럭",
			"83:0" => "사탕수수 (블럭)",

			"85:0" => "울타리",
			"85:1" => "가문비나무 울타리",
			"85:2" => "자작나무 울타리",
			"85:3" => "정글 나무 울타리",
			"85:4" => "아카시아 나무 울타리",
			"85:5" => "짙은 참나무 울타리",
			"86:0" => "호박",
			"87:0" => "네더랙",
			"88:0" => "소울 샌드",
			"89:0" => "발광석",
			"90:0" => "포탈",
			"91:0" => "잭 오 랜턴",
			"92:0" => "케이크 (블럭)",
			"93:0" => "꺼진 레드스톤 중계기 (블럭)",
			"94:0" => "켜진 레드스톤 중계기 (블럭)",
			"95:0" => "보이지 않는 베드락",
			"96:0" => "다락문",
			"97:0" => "몬스터 에그 돌",
			"97:1" => "몬스터 에그 조약돌",
			"97:2" => "몬스터 에그 석재벽돌",
			"97:3" => "몬스터 에그 이끼낀 석재벽돌",
			"97:4" => "몬스터 에그 깨진 석재벽돌",
			"97:5" => "몬스터 에그 조각된 석재벽돌",
			"98:0" => "석재 벽돌",
			"98:1" => "이끼 낀 석재 벽돌",
			"98:2" => "깨진 석재 벽돌",
			"98:3" => "조각된 석재벽돌",
			"99:0" => "갈색 버섯 (블럭)",
			"100:0" => "빨간색 버섯 (블럭)",
			"101:0" => "철창",
			"102:0" => "유리판",
			"103:0" => "수박 (블럭)",
			"104:0" => "호박 줄기",
			"105:0" => "수박 줄기",
			"106:0" => "덩굴",
			"107:0" => "울타리 문",
			"108:0" => "벽돌 계단",
			"109:0" => "석재 벽돌 계단",
			"110:0" => "균사체",
			"111:0" => "연꽃잎",
			"112:0" => "네더 벽돌 블럭",
			"113:0" => "네더 벽돌 울타리",
			"114:0" => "네더 벽돌 계단",
			"115:0" => "네더 와트 (블럭)",
			"116:0" => "마법부여대",
			"117:0" => "양조기 (블럭)",
			"118:0" => "가마솥 (블럭)",

			"120:0" => "엔더 포탈 프레임",
			"121:0" => "엔드 스톤",

			"123:0" => "레드스톤 조명",
			"124:0" => "켜진 레드스톤 조명",
			"125:0" => "공급기",
			"126:0" => "활성화 레일",
			"127:0" => "코코아 콩 (블럭)",
			"128:0" => "사암 계단",
			"129:0" => "에메랄드 원석",

			"131:0" => "철사덫 갈고리",
			"132:0" => "철사덫",
			"133:0" => "에메랄드 블럭",
			"134:0" => "가문비나무 계단",
			"135:0" => "자작나무 계단",
			"136:0" => "정글 나무 계단",

			"139:0" => "조약돌 담장",
			"139:1" => "이끼 낀 돌 담장",
			"140:0" => "화분 (블럭)",
			"141:0" => "당근 (블럭)",
			"142:0" => "감자 (블럭)",
			"143:0" => "나무 버튼",
			"144:0" => "스켈레톤 머리",
			"144:1" => "위더 스켈레톤 머리",
			"144:2" => "좀비 머리",
			"144:3" => "스티브 머리",
			"144:4" => "크리퍼 머리",
			"145:0" => "모루",
			"145:1" => "약간 손상된 모루",
			"145:2" => "심각하게 손상된 모루",
			"146:0" => "덫 상자",
			"147:0" => "무게 감압판 (경형)",
			"148:0" => "무게 감압판 (중형)",
			"149:0" => "꺼진 레드스톤 비교기",
			"150:0" => "켜진 레드스톤 비교기",
			"151:0" => "햇빛 감지기",
			"152:0" => "레드스톤 블럭",
			"153:0" => "네더 석영 원석",
			"154:0" => "깔대기",
			"155:0" => "석영 블럭",
			"155:1" => "조각된 석영 블럭",
			"155:2" => "석영 기둥",
			"156:0" => "석영 계단",
			"157:0" => "참나무 목재 (더블)",
			"157:1" => "가문비나무 목재 (더블)",
			"157:2" => "자작나무 목재 (더블)",
			"157:3" => "정글 나무 목재 (더블)",
			"157:4" => "아카시아 나무 목재 (더블)",
			"157:5" => "짙은 참나무 목재 (더블)",
			"158:0" => "참나무 목재 반블럭",
			"158:1" => "가문비나무 목재 반블럭",
			"158:2" => "자작나무 목재 반블럭",
			"158:3" => "정글 나무 목재 반블럭",
			"158:4" => "아카시아 나무 목재 반블럭",
			"158:5" => "짙은참 나무 목재 반블럭",
			"159:0" => "하얀색 염색된 점토",
			"159:1" => "주황색 염색된 점토",
			"159:2" => "자홍색 염색된 점토",
			"159:3" => "하늘색 염색된 점토",
			"159:4" => "노랑색 염색된 점토",
			"159:5" => "연두색 염색된 점토",
			"159:6" => "분홍색 염색된 점토",
			"159:7" => "회색 염색된 점토",
			"159:8" => "밝은 회색 염색된 점토",
			"159:9" => "청록색 염색된 점토",
			"159:10" => "보라색 염색된 점토",
			"159:11" => "파랑색 염색된 점토",
			"159:12" => "갈색 염색된 점토",
			"159:13" => "초록색 염색된 점토",
			"159:14" => "빨간색 염색된 점토",
			"159:15" => "검은색 염색된 점토",

			"161:0" => "아카시아 나무 잎",
			"161:1" => "짙은 참나무 잎",
			"162:0" => "아카시아 나무",
			"162:1" => "짙은 참나무",
			"163:0" => "아카시아 나무 계단",
			"164:0" => "짙은 참나무 계단",
			"165:0" => "슬라임 블럭",

			"167:0" => "철 다락문",

			"170:0" => "건초 더미",
			"171:0" => "흰색 카펫",
			"171:1" => "주황색 카펫",
			"171:2" => "자홍색 카펫",
			"171:3" => "하늘색 카펫",
			"171:4" => "노랑색 카펫",
			"171:5" => "연두색 카펫",
			"171:6" => "분홍색 카펫",
			"171:7" => "회색 카펫",
			"171:8" => "밝은 회색 카펫",
			"171:9" => "청록색 카펫",
			"171:10" => "보라색 카펫",
			"171:11" => "파랑색 카펫",
			"171:12" => "갈색 카펫",
			"171:13" => "초록색 카펫",
			"171:14" => "빨간색 카펫",
			"171:15" => "검은색 카펫",
			"172:0" => "굳은 점토",
			"173:0" => "석탄 블럭",
			"174:0" => "단단한 얼음",
			"175:0" => "해바라기",
			"175:1" => "라일락",
			"175:2" => "큰 잔디",
			"175:3" => "큰 고사리",
			"175:4" => "장미덩쿨",
			"175:5" => "모란",

			"178:0" => "햇빛 감지기",
			"179:0" => "붉은 사암",
			"180:0" => "붉은 사암 계단",
			"181:0" => "붉은 사암 반블럭 (더블)",
			"182:0" => "붉은 사암 반블럭",
			"183:0" => "가문비나무 울타리 문",
			"184:0" => "자작나무 울타리 문",
			"185:0" => "정글 나무 울타리 문",
			"186:0" => "짙은 참나무 울타리 문",
			"187:0" => "아카시아 나무 울타리 문",

			"193:0" => "가문비나무 문",
			"194:0" => "자작나무 문",
			"195:0" => "정글 나무 문",
			"196:0" => "아카시아 문",
			"197:0" => "짙은참나무 문",
			"198:0" => "잔디길",
			"199:0" => "아이템 액자 블럭",

			"243:0" => "회백토",
			"244:0" => "사탕무 줄기",
			"245:0" => "돌 절단기",
			"246:0" => "빛나는 흑요석",
			"247:0" => "네더 코어",
			"247:1" => "빛나는 네더 코어",
			"247:2" => "꺼진 네더 코어",
			"248:0" => "업데이트 블럭",
			"249:0" => "업데이트 블럭",
			"250:0" => "피스톤에 의해 움직여진 블럭",
			"251:0" => "관찰자 블럭",

			"256:0" => "철 삽",
			"257:0" => "철 곡괭이",
			"258:0" => "철 도끼",
			"259:0" => "라이터",
			"260:0" => "사과",
			"261:0" => "활",
			"262:0" => "화살",
			"262:1" => "뽀족한 화살(효과없음)",
			"262:2" => "뾰족한 화살(효과없음)",
			"262:3" => "뾰족한 화살(효과없음)",
			"262:4" => "뾰족한 화살(효과없음)",
			"262:5" => "뾰족한 화살(효과없음)",
			"262:6" => "야간 투시 화살 (야간 투시 (0:22))",
			"262:7" => "야간 투시 화살 (야간 투시 (1:00))",
			"262:8" => "투명 화살 (투명화 (0:22))",
			"262:9" => "투명 화살 (투명화 (1:00))",
			"262:10" => "도약 화살 (점프 강화 (0:22))",
			"262:11" => "도약 화살 (점프 강화 (1:00))",
			"262:12" => "도약 화살 (점프 강화 II (0:11)",
			"262:13" => "화염 저항 화살 (화염 저항 (0:22))",
			"262:14" => "화염 저항 화살 (화염 저항 (1:00))",
			"262:15" => "민첩의 화살 (신속 (0:22))",
			"262:16" => "민첩의 화살 (신속 (1:00))",
			"262:17" => "민첩의 화살 (신속 II (0:11))",
			"262:18" => "느림의 화살 (구속 (0:11))",
			"262:19" => "느림의 화살 (구속 (0:30))",
			"262:20" => "수중 호흡 화살 (수중 호흡 (0:22))",
			"262:21" => "수중 호흡 화살 (수중 호흡 (1:00))",
			"262:22" => "치유 화살 (즉시 회복)",
			"262:23" => "치유 화살 (즉시 회복 II)",
			"262:24" => "고통의 화살 (즉시 피해)",
			"262:25" => "고통의 화살 (즉시 피해 II)",
			"262:26" => "독화살 (독 (0:05))",
			"262:27" => "독화살 (독 (0:15))",
			"262:28" => "독화살 (독 II (0:02))",
			"262:29" => "재생의 화살 (재생 (0:05))",
			"262:30" => "재생의 화살 (재생 (0:15))",
			"262:31" => "재생의 화살 (재생 II (0:02))",
			"262:32" => "힘의 화살 (힘 (0:22))",
			"262:33" => "힘의 화살 (힘 (1:00))",
			"262:34" => "힘의 화살 (힘 II (0:11))",
			"262:35" => "약화의 화살 (나약함 (0:11))",
			"262:36" => "약화의 화살 (나약함 (0:30))",
			"263:0" => "석탄",
			"263:1" => "목탄",
			"264:0" => "다이아몬드",
			"265:0" => "철괴",
			"266:0" => "금괴",
			"267:0" => "철 칼",
			"268:0" => "나무 칼",
			"269:0" => "나무 삽",
			"270:0" => "나무 곡괭이",
			"271:0" => "나무 도끼",
			"272:0" => "돌 칼",
			"273:0" => "돌 삽",
			"274:0" => "돌 곡괭이",
			"275:0" => "돌도끼",
			"276:0" => "다이아몬드 칼",
			"277:0" => "다아아몬드 삽",
			"278:0" => "다이아몬드 곡괭이",
			"279:0" => "다이아몬드 도끼",
			"280:0" => "막대기",
			"281:0" => "그릇",
			"282:0" => "버섯 스튜",
			"283:0" => "금 칼",
			"284:0" => "금 삽",
			"285:0" => "금 곡괭이",
			"286:0" => "금 도끼",
			"287:0" => "실",
			"288:0" => "깃털",
			"289:0" => "화약",
			"290:0" => "나무 괭이",
			"291:0" => "돌 괭이",
			"292:0" => "철 괭이",
			"293:0" => "다이아몬드 괭이",
			"294:0" => "금 괭이",
			"295:0" => "씨앗",
			"296:0" => "밀",
			"297:0" => "빵",
			"298:0" => "가죽 모자",
			"299:0" => "가죽 튜닉",
			"300:0" => "가죽 바지",
			"301:0" => "가죽 신발",
			"302:0" => "사슬 투구",
			"303:0" => "사슬 갑옷",
			"304:0" => "사슬 레깅스",
			"305:0" => "사슬 부츠",
			"306:0" => "철 투구",
			"307:0" => "철 갑옷",
			"308:0" => "철 레깅스",
			"309:0" => "철 부츠",
			"310:0" => "다이아몬드 투구",
			"311:0" => "다이아몬드 갑옷",
			"312:0" => "다이아몬드 레깅스",
			"313:0" => "다이아몬드 부츠",
			"314:0" => "금 투구",
			"315:0" => "금 갑옷",
			"316:0" => "금 레깅스",
			"317:0" => "금 부츠",
			"318:0" => "부싯돌",
			"319:0" => "익히지 않은 돼지고기",
			"320:0" => "구운 돼지고기",
			"321:0" => "그림",
			"322:0" => "황금 사과",
			"323:0" => "표지판",
			"324:0" => "나무 문",
			"325:0" => "양동이",
			"325:1" => "우유 양동이",
			"325:8" => "물 양동이",
			"325:10" => "용암 양동이",

			"328:0" => "마인카트",
			"329:0" => "안장",
			"330:0" => "철문",
			"331:0" => "레드스톤",
			"332:0" => "눈덩이",
			"333:0" => "보트",
			"334:0" => "가죽",

			"336:0" => "점토 벽돌",
			"337:0" => "점토",
			"338:0" => "사탕수수",
			"339:0" => "종이",
			"340:0" => "책",
			"341:0" => "슬라임볼",
			"342:0" => "상자 광물 수레",

			"344:0" => "달걀",
			"345:0" => "나침판",
			"346:0" => "낚시대",
			"347:0" => "시계",
			"348:0" => "발광석 가루",
			"349:0" => "날 생선",
			"349:1" => "날 연어",
			"349:2" => "흰둥가리",
			"349:3" => "복어",
			"350:0" => "익힌 생선",
			"350:1" => "익힌 연어",
			"351:0" => "먹물",
			"351:1" => "빨간 장미 염료",
			"351:2" => "초록 선인장 염료",
			"351:3" => "코코아 콩",
			"351:4" => "청금석",
			"351:5" => "보라색 염료",
			"351:6" => "청록색 염료",
			"351:7" => "밝은 회색 염료",
			"351:8" => "회색 염료",
			"351:9" => "분홍색 염료",
			"351:10" => "연두색 염료",
			"351:11" => "민들레 노랑 염료",
			"351:12" => "하늘색 염료",
			"351:13" => "자홍색 염료",
			"351:14" => "주황색 염료",
			"351:15" => "뼛가루",
			"352:0" => "뼈",
			"353:0" => "설탕",
			"354:0" => "케이크",
			"355:0" => "침대",
			"356:0" => "레드스톤 중계기",
			"357:0" => "쿠키",
			"359:0" => "가위",
			"360:0" => "수박",
			"361:0" => "호박 씨",
			"362:0" => "수박 씨",
			"363:0" => "익히지 않은 소고기",
			"364:0" => "스테이크",
			"365:0" => "익히지 않은 닭고기",
			"366:0" => "구운 닭고기",
			"367:0" => "썩은 고기",

			"369:0" => "블레이즈 막대",
			"370:0" => "가스트의 눈물",
			"371:0" => "금 조각",
			"372:0" => "네더 와트",
			"373:0" => "물병",
			"373:1" => "평범한 포션 (효과 없음)",
			"373:2" => "평범한 포션 (효과 없음)",
			"373:3" => "진한 포션 (효과 없음)",
			"373:4" => "이상한 포션 (효과 없음)",
			"373:5" => "야간 투시 포션 (야간 투시 (3:00))",
			"373:6" => "야간 투시 포션 (야간 투시 (8:00))",
			"373:7" => "투명화 포션 (투명화 (3:00))",
			"373:8" => "투명화 포션 (투명화 (8:00))",
			"373:9" => "도약의 포션 (점프 강화 (3:00))",
			"373:10" => "도약의 포션 (점프 강화 (8:00))",
			"373:11" => "도약의 포션 (점프 강화 II (1:30))",
			"373:12" => "화염 저항 포션 (화염 저항 (3:00))",
			"373:13" => "화염 저항 포션 (화염 저항 (8:00))",
			"373:14" => "신속의 포션 (신속 (3:00))",
			"373:15" => "신속의 포션 (신속 (8:00))",
			"373:16" => "신속의 포션 (신속 II (1:30))",
			"373:17" => "구속의 포션 (구속 (1:30))",
			"373:18" => "구속의 포션 (구속 (4:00))",
			"373:19" => "수중 호흡 포션 (수중 호흡 (3:00))",
			"373:20" => "수중 호흡 포션 (수중 호흡 (8:00))",
			"373:21" => "회복 포션 (즉시 회복)",
			"373:22" => "회복 포션 (즉시 회복 II)",
			"373:23" => "고통의 포션 (즉시 피해)",
			"373:24" => "고통의 포션 (즉시 피해 II)",
			"373:25" => "독 포션 (독 (0:45))",
			"373:26" => "독 포션 (독 (2:00))",
			"373:27" => "독 포션 (독 II (0:22))",
			"373:28" => "재생 포션 (재생 (0:45))",
			"373:29" => "재생 포션 (재생 (2:00))",
			"373:30" => "재생 포션 (재생 II (0:22))",
			"373:31" => "힘의 포션 (힘 (3:00))",
			"373:32" => "힘의 포션 (힘 (8:00))",
			"373:33" => "힘의 포션 (힘 II (1:30))",
			"373:34" => "나약의 포션 (나약함 (1:30))",
			"373:35" => "나약의 포션 (나약함 (4:00))",
			"374:0" => "유리병",
			"375:0" => "거미 눈",
			"376:0" => "발효된 거미 눈",
			"377:0" => "블레이즈 가루",
			"378:0" => "마그마 크림",
			"379:0" => "양조기",
			"380:0" => "가마솥",

			"382:0" => "반짝이는 수박",
			"383:0" => "스폰알",
			"383:10" => "닭 스폰알",
			"383:11" => "소 스폰알",
			"383:12" => "돼지 스폰알",
			"383:13" => "양 스폰알",
			"383:14" => "늑대 스폰알",
			"383:15" => "주민 스폰알",
			"383:16" => "버섯소 스폰알",
			"383:17" => "오징어 스폰알",
			"383:19" => "박쥐 스폰알",
			"383:22" => "오셀롯 스폰알",
			"383:33" => "좀비 스폰알",
			"383:34" => "스켈레톤 스폰알",
			"383:35" => "거미 스폰알",
			"383:36" => "돼지좀비 스폰알",
			"383:37" => "슬라임 스폰알",
			"383:38" => "엔더맨 스폰알",
			"383:39" => "실버피쉬 스폰알",
			"383:40" => "동굴거미 스폰알",
			"383:41" => "가스트 스폰알",
			"383:42" => "마그마 큐브 스폰알",
			"383:43" => "블레이즈 스폰알",
			"384:0" => "경험치 병",

			"388:0" => "에메랄드",
			"389:0" => "아이템 액자",
			"390:0" => "화분",
			"391:0" => "당근",
			"392:0" => "감자",
			"393:0" => "구운 감자",
			"394:0" => "독이 있는 감자",
			"395:0" => "빈 지도",
			"396:0" => "황금 당근",
			"397:0" => "스켈레톤 머리",
			"397:1" => "위더스켈레톤 머리",
			"397:2" => "좀비 머리",
			"397:3" => "머리",
			"397:4" => "크리퍼 머리",
			"398:0" => "당근 낚싯대",

			"400:0" => "호박파이",

			"403:0" => "마법부여된 책",
			"404:0" => "레드스톤 비교기",
			"405:0" => "네더 벽돌",
			"406:0" => "석영",
			"407:0" => "TNT 광물 수레",
			"408:0" => "깔때기 광물 수레",

			"410:0" => "깔때기",
			"411:0" => "익히지 않은 토끼고기",
			"412:0" => "구운 토끼고기",
			"413:0" => "토끼 스튜",
			"414:0" => "토끼 발",
			"415:0" => "토끼 가죽",
			"416:0" => "가죽 말 갑옷",
			"417:0" => "철 말 갑옷",
			"418:0" => "금 말 갑옷",
			"419:0" => "다이아몬드 말 갑옷",
			"420:0" => "목줄",
			"421:0" => "이름표",

			"423:0" => "익히지 않은 양고기",
			"424:0" => "구운 양고기",

			"427:0" => "가문비나무 문",
			"428:0" => "자작나무 문",
			"429:0" => "정글 나무 문",
			"430:0" => "아카시아 나무 문",
			"431:0" => "짙은 참나무 문",

			"438:0" => "투척용 포션",
			"438:1" => "투척용 평범한 포션",
			"438:2" => "투척용 평범한 포션",
			"438:3" => "투척용 진한 포션",
			"438:4" => "투척용 이상한 포션",
			"438:5" => "투척용 야간 투시 포션 (야간 투시 (2:15))",
			"438:6" => "투척용 야간 투시 포션 (야간 투시 (6:00))",
			"438:7" => "투척용 투명화 포션 (투명화 (2:15))",
			"438:8" => "투척용 투명화 포션 (투명화 (6:00))",
			"438:9" => "투척용 도약의 포션 (점프 강화 (2:15))",
			"438:10" => "투척용 도약의 포션 (점프 강화 (6:00))",
			"438:11" => "투척용 도약의 포션 (점프 강화 II (1:07))",
			"438:12" => "투척용 화염 저항 포션 (화염 저항 (2:15))",
			"438:13" => "투척용 화염 저항 포션 (화염 저항 (6:00))",
			"438:14" => "투척용 신속의 포션 (신속 (2:15))",
			"438:15" => "투척용 신속의 포션 (신속 (6:00))",
			"438:16" => "투척용 신속의 포션 (신속 II (1:07))",
			"438:17" => "투척용 구속의 포션 (구속 (1:07))",
			"438:18" => "투척용 구속의 포션 (구속 (3:00))",
			"438:19" => "투척용 수중 호흡 포션 (수중 호흡 (2:15))",
			"438:20" => "투척용 수중 호흡 포션 (수중 호흡 (6:00))",
			"438:21" => "투척용 회복 포션 (즉시 회복)",
			"438:22" => "투척용 회복 포션 (즉시 회복 II)",
			"438:23" => "투척용 고통의 포션 (즉시 피해)",
			"438:24" => "투척용 고통의 포션 (즉시 피해 II)",
			"438:25" => "투척용 독 포션 (독 (0:33))",
			"438:26" => "투척용 독 포션 (독 (1:30))",
			"438:27" => "투척용 독 포션 (독 II (0:16))",
			"438:28" => "투척용 재생 포션 (재생 (0:33))",
			"438:29" => "투척용 재생 포션 (재생 (1:30))",
			"438:30" => "투척용 재생 포션 (재생 II (0:16))",
			"438:31" => "투척용 힘의 포션 (힘 (2:15))",
			"438:32" => "투척용 힘의 포션 (힘 (6:00))",
			"438:33" => "투척용 힘의 포션 (힘 II (1:07))",
			"438:34" => "투척용 냐약의 포션 (1:07))",
			"438:35" => "투척용 나약의 포션 (3:00))",

			"444:0" => "가문비나무 보트",
			"445:0" => "자작나무 보트",
			"446:0" => "정글 나무 보트",
			"447:0" => "아카시아 나무 보트",
			"448:0" => "짙은 참나무 보트",

			"457:0" => "사탕무",
			"458:0" => "사탕무 씨앗",
			"459:0" => "사탕무 수프",
			"460:0" => "날 연어",
			"461:0" => "흰동가리",
			"462:0" => "복어",
			"463:0" => "익힌 연어",

			"466:0" => "황금 사과",

			"498:0" => "카메라"
		]);
		$this->itemData = $this->itemconfig->getAll();

		$this->enchantconfig = new Config ($this->getDataFolder() . "enchant.yml", Config::YAML, [

			/*
			#인챈트 코드 Based PC 1.7.1
			#수정: SOLO
			#출처: http://mendel.tistory.com/m/post/entry/마인크래프트-인첸트코드-17234
			*/

			"0" => "보호",
			"1" => "화염 보호",
			"2" => "가벼운 착지",
			"3" => "폭파 보호",
			"4" => "원거리 보호",
			"5" => "호흡",
			"6" => "친수성",
			"7" => "가시",
			"16" => "날카로움",
			"17" => "강타",
			"18" => "살충",
			"19" => "밀치기",
			"20" => "화염",
			"21" => "약탈",
			"32" => "효율",
			"33" => "섬세한 손길",
			"34" => "내구성",
			"35" => "행운",
			"48" => "힘",
			"49" => "밀어내기",
			"50" => "화염",
			"51" => "무한"
		]);
		$this->enchantData = $this->enchantconfig->getAll();

		$this->effectconfig = new Config ($this->getDataFolder() . "effect.yml", Config::YAML, [

			/*
			#이펙트 코드 Based PC 1.7.1
			#수정: SOLO
			#출처: http://mendel.tistory.com/m/post/entry/마인크래프트-이펙트코드-17234
			*/

			"1" => "신속",
			"2" => "구속",
			"3" => "성급함",
			"4" => "피로",
			"5" => "힘",
			"6" => "즉시 회복",
			"7" => "즉시 데미지",
			"8" => "점프강화",
			"9" => "멀미",
			"10" => "재생",
			"11" => "저항",
			"12" => "화염 저항",
			"13" => "수중 호흡",
			"14" => "투명화",
			"15" => "실명",
			"16" => "야간 투시",
			"17" => "허기",
			"18" => "나약함",
			"19" => "독",
			"20" => "위더",
			"21" => "체력 신장",
			"22" => "흡수",
			"23" => "포화"

		]);
		$this->effectData = $this->effectconfig->getAll();

		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}






	//==Π==Π==Π==Π==Π==Π==Π==Π==Π==Π==Π==//
	//<|<|<|<|<|<|<|<# SearchCode API #>|>|>|>|>|>|>|>|>//
	//==Π==Π==Π==Π==Π==Π==Π==Π==Π==Π==Π==//
	/*
	 아이템 코드를 한글 아이템 이름으로 바꿔주는 함수입니다.
	 $code 에는 <아이템 코드>:<데미지> 형식으로 넣어주시면
	 아이템 이름을 반환해줍니다.
	 $array 에는 아이템 리스트를 넣어주셔야 합니다.
	 만일 한글 아이템 코드 리스트에 없다면, "알 수 없음" 을
	 반환합니다.
	*/
	public function SearchItemCode($code, $array){
		$code = explode(':', $code);
		if(isset($array[$code]))
			return $array[$code];
		/*foreach(array_keys($array) as $i)
	   {
		  $a = explode(':', $i);
		  if($a[0] == $code[0])
		 {
			if(!isset($array[$a[0].':'.$code[1]])) return $array[$a[0].':0'];
			else return $array[$a[0].':'.$code[1]];
		  }
		}
	*/
		return "알 수 없음";
	}

	/*
	인챈트코드, 이펙트코드에 알맞은 함수
	*/
	public function SearchCode($code, $array){
		foreach(array_keys($array) as $i)
			if($i == $code)
				return $array[$i];
		return "알 수 없음";
	}







	//==Π==Π==Π==Π==Π==Π==Π==Π==Π==Π==Π==//
	//<|<|<|<|<|<|<|<# SearchNum API #>|>|>|>|>|>|>|>|>//
	//==Π==Π==Π==Π==Π==Π==Π==Π==Π==Π==Π==//

	public function SearchSingle($code, $array){
		if(strpos(':', $code))
			return $this->SearchItemCode($code, $array);else return $this->SearchCode($code, $array);
	}

	//return array (코드 => 아이템이름)
	public function SearchDouble($startcode, $endcode, $array){
		$output = [];
		$str = (double) str_replace(':', '.', $startcode);
		$end = (double) str_replace(':', '.', $endcode);
		if($str < $end){
			$a = $str;
			$b = $end;
		}else if($str > $end){
			$a = $end;
			$b = $str;
		}else if($str == $end){
			$output[$startcode] = $this->SearchSingle($startcode, $array);
			return $output;
		}else return $output;
		foreach(array_keys($array) as $arr){
			$num = (double) str_replace(':', '.', $arr);
			if($a <= $num && $b >= $num)
				$output[$arr] = $array[$arr];else if($b < $num)
				break;
		}
		return $output;
	}

	//return array
	public function SearchMultiple($codarray, $array){
		$output = [];
		foreach($codarray as $k => $v){
			if(isset($array[$v]))
				$output[$v] = $array[$v];else $output[$v] = "알 수 없음";
		}
		return $output;
	}

	public function SearchKor($strarray, $array){
		$output = [];
		foreach($array as $k => $v){
			foreach($strarray as $str){
				if(preg_match("/$str/", str_replace(' ', '', $v))){
					$output[$k] = str_replace($str, "§a" . $str . "§7", $v);
					continue;
				}
			}
		}
		return $output;
	}









	//==Π==Π==Π==Π==Π==Π==Π==Π==Π==Π==Π==//
	//<|<|<|<|<|<|<|<|<|<#  ETC API  #>|>|>|>|>|>|>|>|>|>|>//
	//==Π==Π==Π==Π==Π==Π==Π==Π==Π==Π==Π==//

	public function CodeToItemCode($code){
		$code = explode(':', $code);
		if(count($code) == 1)
			return $code[0] . ':0';else return $code[0] . ':' . $code[1];
	}

	public function pagenum(){
		return $this->configData['page'];
	}







	//==Π==Π==Π==Π==Π==Π==Π==Π==Π==Π==Π==//
	//<|<|<|<|<|<|<|<|<|<#  Non-API  #>|>|>|>|>|>|>|>|>|>|>//
	//==Π==Π==Π==Π==Π==Π==Π==Π==Π==Π==Π==//

	public function onCommand(CommandSender $sender, Command $command, $label, array $args) : bool{
		if($command->getName() == "아이템코드" || $command->getName() == "iv"){
			if(!isset($args[0]) && $command->getName() == "iv"){
				if(!$sender instanceof Player){
					$sender->sendMessage("§b§o[ 알림 ] §7인게임에서만 가능합니다.");
					return true;
				}
				$itemhand = $sender->getInventory()->getItemInHand();
				$code = $itemhand->getId() . ":" . $itemhand->getMeta();
				$name = $this->SearchSingle($code, $this->itemData);
				$sender->sendMessage("§b§o[ 알림 ] §7아이템 코드 : " . $code . "  아이템 이름 : " . $name);
				return true;
			}
			if(!$sender->hasPermission(DefaultPermissions::ROOT_OPERATOR)){
				$sender->sendMessage("§b§o[ 알림 ] §7권한이 없습니다.");
				return true;
			}
			if(!isset($args[0])) //도움말 표시
			{
				$sender->sendMessage("§b§o[ 알림 ] §7====== 사용법 ======");
				$sender->sendMessage("§b§o[ 알림 ] §7/iv - 손에 들고있는 아이템의 코드를 출력합니다. 또는 아이템코드 명령어로 사용가능합니다.");
				$sender->sendMessage("§b§o[ 알림 ] §7/아이템코드 [코드] - 해당 코드의 아이템 이름을 출력합니다.");
				$sender->sendMessage("§b§o[ 알림 ] §7/아이템코드 [코드]~[코드] - 코드 사이에 있는 아이템들을 출력합니다.");
				$sender->sendMessage("§b§o[ 알림 ] §7/아이템코드 [코드],[코드],[코드]... - 해당 코드의 아이템들을 출력합니다.");
				$sender->sendMessage("§b§o[ 알림 ] §7/아이템코드 [키워드] - 키워드로 아이템을 검색합니다.");
				$sender->sendMessage("§b§o[ 알림 ] §7/아이템코드 [키워드],[키워드],[키워드]... - 키워드로 아이템들을 검색합니다.");
				return true;
			}

			if(is_numeric(str_replace(':', '', $args[0]))){
				$code = $this->CodeToItemCode($args[0]);
				$name = $this->SearchSingle($code, $this->itemData);
				$sender->sendMessage("§b§o[ 알림 ] §7아이템 코드 : " . $code . "  아이템 이름 : " . $name);
				return true;
			}

			//**************************************************//
			//☞ /아이템코드 [숫자]
			//**************************************************//
			if(is_numeric(str_replace(['~', ',', ':'], ['', '', ''], $args[0]))){
				//**************************************************//
				//☞ /아이템코드 [코드:데미지]~[코드:데미지]
				//**************************************************//
				if(is_numeric(str_replace(['~', ':'], ['', ''], $args[0]))){
					$t = explode('~', $args[0]);
					if(count($t) > 2 || count($t) < 2 || !is_numeric(str_replace(':', '', $t[0])) || !is_numeric(str_replace(':', '', $t[1]))){
						$sender->sendMessage("§b§o[ 알림 ] §7사용법 : /아이템코드 [코드]~[코드]");
						return true;
					}
					foreach($this->SearchDouble($t[0], $t[1], $this->itemData) as $k => $v){
						$sender->sendMessage("§b§o[ 알림 ] §7아이템 코드 : " . $k . "  아이템 이름 : " . $v);
					}
					return true;

					//**************************************************//
					//☞ /아이템코드 [코드:데미지],[코드:데미지],[코드:데미지]
					//**************************************************//
				}else if(is_numeric(str_replace([',', ':'], ['', ''], $args[0]))){
					$t = explode(',', $args[0]);
					foreach($t as $k => $v){
						$t[$k] = $this->CodeToItemCode($v);
					}
					foreach($this->SearchMultiple($t, $this->itemData) as $k => $v){
						$sender->sendMessage("§b§o[ 알림 ] §7아이템 코드 : " . $k . "  아이템 이름 : " . $v);
					}
					return true;
				}

				//**************************************************//
				//☞ /아이템코드 [키워드],[키워드],[키워드]
				//**************************************************//
			}else{
				$t = explode(',', $args[0]);
				foreach($t as $k => $v){
					if($v == '')
						unset($t[$k]);
				}
				$impl = implode(', ', $t);
				$sender->sendMessage("§b§o[ 알림 ] §7검색 결과 ( " . $impl . " )");
				foreach($this->SearchKor($t, $this->itemData) as $k => $v){
					$sender->sendMessage("§b§o[ 알림 ] §7아이템 코드 : " . $k . "  아이템 이름 : " . $v);
				}
				if(count($this->SearchKor($t, $this->itemData)) == 0){
					$sender->sendMessage("§b§o[ 알림 ] §7검색 결과가 없습니다.");
					return true;
				}
				return true;
			}
		}else if($command->getName() == "이펙트코드" || $command->getName() == "인챈트코드"){
			if(!$sender->hasPermission(DefaultPermissions::ROOT_OPERATOR)){
				$sender->sendMessage("§b§o[ 알림 ] §7권한이 없습니다.");
				return true;
			}
			switch($command->getName()){
				case '이펙트코드':
					$mode = true;
					break;
				case '인챈트코드':
					$mode = false;
					break;
			}
			if(!isset($args[0]) || !is_numeric($args[0])){
				$args[0] = 1;
			}
			$output = [];
			$mode ? $arr = $this->effectData : $arr = $this->enchantData;
			$c = 0;
			$maxp = ceil(count(array_keys($arr)) / $this->pagenum());
			if($args[0] > $maxp)
				$args[0] = $maxp;
			if($args[0] == 0)
				$args[0] = 1;
			foreach($arr as $k => $v){
				$p = $this->pagenum() * $args[0];
				++$c;
				if($c < $p - $this->pagenum())
					continue;
				if($c > $p)
					break;
				$output[$k] = $v;
			}
			$mode ? $i = "이펙트" : $i = "인챈트";
			$sender->sendMessage("§b§o[ 알림 ] §7" . $i . " 코드 목록  (" . $args[0] . "/" . $maxp . "페이지)   /" . $i . "코드 [페이지]");
			foreach($output as $k => $v){
				$sender->sendMessage($v . " ( 코드 : " . $k . " )");
			}
			return true;
		}
	}//함수 괄호

}//클래스 괄호

?>
