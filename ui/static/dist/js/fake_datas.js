

var normalAmmeterDaily = 5000;
var monitorSummary = {
	"code": "10000",
	"msg": "success",
	"sub_code": "",
	"sub_msg": "success",
	"result": {
		"from": "2019-06-08",
		"to": "2019-06-08",
		"building": {
			"id": 1,
			"name": "大楼一号",
			"capacity": 12000,
			"capacity_text": "日耗电1.2w度",
			"area": 10000,
			"fee_policy": "{\r\n\t\"ammeter\": 0.85,\r\n\t\"watermeter\": 2.2,\r\n\t\"gasmeter\": 1.9,\r\n\t\"vapormeter\": 3.5\r\n}",
			"status": "已建成",
			"type": "政府项目",
			"photo": "https:\/\/static-pvm.sunallies.com\/business.jpg",
			"address": "浙江省宁波市宁海县金港路26号",
			"latitude": 29.304051000000001,
			"longitude": 121.62177800000001,
			"location_id": 61,
			"owner_id": 1,
			"note": null,
			"created_at": "2019-02-11 18:00:36",
			"updated_at": "2019-02-11 18:00:36"
		},
		"summaryData": {
			"internationalValue": 0.14999999999999999,
			"total1Name": "总电量",
			"total1Unit": "kwh",
			"total1": "310303.2000",
			"totalCompare1Month": "0",
			"totalCompare1Year": "0",
			"total2Name": "总水量",
			"total2Unit": "吨",
			"total2": 0,
			"totalCompare2Month": 0,
			"totalCompare2Year": 0,
			"total3Name": "总燃气量",
			"total3Unit": "立方米",
			"total3": 0,
			"totalCompare3Month": 0,
			"totalCompare3Year": 0,
			"total4Name": "总蒸汽量",
			"total4Unit": "吨",
			"total4": 0,
			"totalCompare4Month": 0,
			"totalCompare4Year": 0
		},
		"chartDatas": {
			"ammeter": {
				"datas": [],
				"key": "record_date",
				"val": "useValue",
				"unit": "kwh",
				"prop_area": 10000,
				"name": "电量",
				"area": 10000,
				"fee_policy": 0.84999999999999998
			},
			"watermeter": {
				"datas": [],
				"key": "record_date",
				"val": "useValue",
				"unit": "吨",
				"prop_area": 10000,
				"name": "水量",
				"area": 10000,
				"fee_policy": 2.2000000000000002
			},
			"gasmeter": {
				"datas": [],
				"key": "record_date",
				"val": "useValue",
				"unit": "立方米",
				"prop_area": 10000,
				"name": "燃气量",
				"area": 10000,
				"fee_policy": 1.8999999999999999
			},
			"vapormeter": {
				"datas": [],
				"key": "record_date",
				"val": "useValue",
				"unit": "吨",
				"prop_area": 10000,
				"name": "蒸汽费",
				"area": 10000,
				"fee_policy": 3.5
			}
		},
		"totalVal": [{
			"name": "总电量",
			"val": "310303.2000"
		}, {
			"name": "总水量",
			"val": 0
		}, {
			"name": "总燃气量",
			"val": 0
		}, {
			"name": "总蒸汽量",
			"val": 0
		}],
		"dailyList": {
			"title": ["日期", "总电量", "总电量密度", "总水量", "总水量密度", "总燃气量", "总燃气量密度", "总蒸汽量", "总蒸汽量密度"],
			"data": [
				["2019-06-08", 4710.3599999999997, 0.46999999999999997, 0, 0, 0, 0, 0, 0]
			]
		}
	}
};



var monitorAmmeterSummary = {
	"code": "10000",
	"msg": "success",
	"sub_code": "",
	"sub_msg": "success",
	"result": {
		"from": "2019-06-18",
		"to": "2019-06-25",
		"building": {
			"id": 1,
			"name": "大楼一号",
			"capacity": 12000,
			"capacity_text": "日耗电1.2w度",
			"area": 10000,
			"fee_policy": "{\r\n\t\"ammeter\": 0.85,\r\n\t\"watermeter\": 2.2,\r\n\t\"gasmeter\": 1.9,\r\n\t\"vapormeter\": 3.5\r\n}",
			"status": "已建成",
			"type": "政府项目",
			"photo": "https:\/\/static-pvm.sunallies.com\/business.jpg",
			"address": "浙江省宁波市宁海县金港路26号",
			"latitude": 29.304051000000001,
			"longitude": 121.62177800000001,
			"location_id": 61,
			"owner_id": 1,
			"note": null,
			"created_at": "2019-02-11 18:00:36",
			"updated_at": "2019-02-11 18:00:36"
		},
		"types": [{
			"id": 9,
			"name": "能耗分项"
		}, {
			"id": 10,
			"name": "建筑区域"
		}, {
			"id": 11,
			"name": "组织机构"
		}, {
			"id": 12,
			"name": "自定义类别"
		}],
		"typeGroups": [],
		"old": [{
			"val": "310303.2000"
		}, {
			"val": "0.0000"
		}, {
			"val": "0.0000"
		}, {
			"val": "310303.2000"
		}, {
			"val": "0.0000"
		}],
		"summaryData": {
			"internationalValue": 0.15,
			"totalName": "总用电量",
			"totalUnit": "kwh",
			"total": "310303.2000",
			"totalCompareMonth": "0",
			"totalCompareYear": "0",
			"total1Name": "当量标煤(吨)",
			"total1Unit": "吨",
			"total1": 100848.54000000001,
			"totalCompare1Month": "0",
			"totalCompare1Year": "0",
			"total2Name": "累计碳排放量(吨)",
			"total2Unit": "吨",
			"total2": 284579.06472000002,
			"totalCompare2Month": "0",
			"totalCompare2Year": "0",
			"total3Name": "能耗密度",
			"total3Unit": "kwh\/m2",
			"total3": 31.03032,
			"totalCompare3Month": "0",
			"totalCompare3Year": "0",
			"total4Name": "费用",
			"total4Unit": "元",
			"total4": 263757.72000000003,
			"totalCompare4Month": "0",
			"totalCompare4Year": "0"
		},
		"chartDatas": {
			"datas": [],
			"key": "record_date",
			"val": "useValue",
			"unit": "kwh",
			"prop_area": 10000,
			"name": "用电量",
			"area": 10000,
			"coal": 0.32500000000000001,
			"co2": 0.91710000000000003,
			"fee_policy": 0.84999999999999998
		},
		"chartCompareDatas": {
			"datas": [],
			"key": "record_date",
			"val": "useValue",
			"unit": "kwh",
			"prop_area": 10000
		},
		"totalVal": "310303.2000",
		"dailyList": {
			"title": ["日期", "总用电量(kwh)", "当量标煤(吨)", "能耗密度(kwh/m2)", "费用(元)"],
			"data": []
		}
	}
}



var monitorAmmeterType = {
	"code": "10000",
	"msg": "success",
	"sub_code": "",
	"sub_msg": "success",
	"result": {
		"from": "2019-06-19",
		"to": "2019-06-26",
		"building": {
			"id": 1,
			"name": "大楼一号",
			"capacity": 12000,
			"capacity_text": "日耗电1.2w度",
			"area": 10000,
			"fee_policy": "{\r\n\t\"ammeter\": 0.85,\r\n\t\"watermeter\": 2.2,\r\n\t\"gasmeter\": 1.9,\r\n\t\"vapormeter\": 3.5\r\n}",
			"status": "已建成",
			"type": "政府项目",
			"photo": "https:\/\/static-pvm.sunallies.com\/business.jpg",
			"address": "浙江省宁波市宁海县金港路26号",
			"latitude": 29.304051000000001,
			"longitude": 121.62177800000001,
			"location_id": 61,
			"owner_id": 1,
			"note": null,
			"created_at": "2019-02-11 18:00:36",
			"updated_at": "2019-02-11 18:00:36"
		},
		"types": [{
			"id": 9,
			"name": "能耗分项"
		}, {
			"id": 10,
			"name": "建筑区域"
		}, {
			"id": 11,
			"name": "组织机构"
		}, {
			"id": 12,
			"name": "自定义类别"
		}],
		"typeGroups": [
		{
			"id": 1,
			"building_id": 1,
			"group_type": 9,
			"name": "照明与插座",
			"parent_id": 0,
			"prop_area": 10000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:08:50",
			"updated_at": "2019-02-01 18:08:50"
		}, {
			"id": 6,
			"building_id": 1,
			"group_type": 9,
			"name": "空调用电",
			"parent_id": 0,
			"prop_area": 5000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:08:48",
			"updated_at": "2019-02-01 18:08:48"
		}, {
			"id": 11,
			"building_id": 1,
			"group_type": 9,
			"name": "动力用电",
			"parent_id": 0,
			"prop_area": 5000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:09:08",
			"updated_at": "2019-02-01 18:09:08"
		}, {
			"id": 15,
			"building_id": 1,
			"group_type": 9,
			"name": "特殊用电",
			"parent_id": 0,
			"prop_area": 15000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:09:13",
			"updated_at": "2019-02-01 18:09:13"
		}, {
			"id": 2,
			"building_id": 1,
			"group_type": 9,
			"name": "照明",
			"parent_id": 1,
			"prop_area": 10000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:04",
			"updated_at": "2019-02-01 18:10:04"
		}, {
			"id": 3,
			"building_id": 1,
			"group_type": 9,
			"name": "插座",
			"parent_id": 1,
			"prop_area": 10000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:04",
			"updated_at": "2019-02-01 18:10:04"
		}, {
			"id": 4,
			"building_id": 1,
			"group_type": 9,
			"name": "公共区域照明",
			"parent_id": 1,
			"prop_area": 10000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:04",
			"updated_at": "2019-02-01 18:10:04"
		}, {
			"id": 5,
			"building_id": 1,
			"group_type": 9,
			"name": "室外景观照明",
			"parent_id": 1,
			"prop_area": 10000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:04",
			"updated_at": "2019-02-01 18:10:04"
		}, {
			"id": 7,
			"building_id": 1,
			"group_type": 9,
			"name": "冷热站",
			"parent_id": 6,
			"prop_area": 5000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:14",
			"updated_at": "2019-02-01 18:10:14"
		}, {
			"id": 8,
			"building_id": 1,
			"group_type": 9,
			"name": "空调末端",
			"parent_id": 6,
			"prop_area": 5000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:14",
			"updated_at": "2019-02-01 18:10:14"
		}, {
			"id": 9,
			"building_id": 1,
			"group_type": 9,
			"name": "净化系统",
			"parent_id": 6,
			"prop_area": 5000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:14",
			"updated_at": "2019-02-01 18:10:14"
		}, {
			"id": 10,
			"building_id": 1,
			"group_type": 9,
			"name": "大型独立空调",
			"parent_id": 6,
			"prop_area": 5000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:14",
			"updated_at": "2019-02-01 18:10:14"
		}, {
			"id": 12,
			"building_id": 1,
			"group_type": 9,
			"name": "电梯",
			"parent_id": 11,
			"prop_area": 5000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:20",
			"updated_at": "2019-02-01 18:10:20"
		}, {
			"id": 13,
			"building_id": 1,
			"group_type": 9,
			"name": "水泵",
			"parent_id": 11,
			"prop_area": 5000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:20",
			"updated_at": "2019-02-01 18:10:20"
		}, {
			"id": 14,
			"building_id": 1,
			"group_type": 9,
			"name": "通风机",
			"parent_id": 11,
			"prop_area": 5000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:20",
			"updated_at": "2019-02-01 18:10:20"
		}, {
			"id": 16,
			"building_id": 1,
			"group_type": 9,
			"name": "网络机房",
			"parent_id": 15,
			"prop_area": 15000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:28",
			"updated_at": "2019-02-01 18:10:28"
		}, {
			"id": 17,
			"building_id": 1,
			"group_type": 9,
			"name": "洗衣房",
			"parent_id": 15,
			"prop_area": 15000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:28",
			"updated_at": "2019-02-01 18:10:28"
		}, {
			"id": 18,
			"building_id": 1,
			"group_type": 9,
			"name": "厨房",
			"parent_id": 15,
			"prop_area": 15000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:28",
			"updated_at": "2019-02-01 18:10:28"
		}, {
			"id": 19,
			"building_id": 1,
			"group_type": 9,
			"name": "电话机房",
			"parent_id": 15,
			"prop_area": 15000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:28",
			"updated_at": "2019-02-01 18:10:28"
		}, {
			"id": 20,
			"building_id": 1,
			"group_type": 9,
			"name": "开闭站",
			"parent_id": 15,
			"prop_area": 15000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:28",
			"updated_at": "2019-02-01 18:10:28"
		}, {
			"id": 21,
			"building_id": 1,
			"group_type": 9,
			"name": "消防用电",
			"parent_id": 15,
			"prop_area": 15000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:28",
			"updated_at": "2019-02-01 18:10:28"
		}, {
			"id": 22,
			"building_id": 1,
			"group_type": 9,
			"name": "租户用电",
			"parent_id": 15,
			"prop_area": 15000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:28",
			"updated_at": "2019-02-01 18:10:28"
		}, {
			"id": 23,
			"building_id": 1,
			"group_type": 9,
			"name": "其他",
			"parent_id": 15,
			"prop_area": 15000,
			"prop_num": 50,
			"created_at": "2019-02-01 18:10:28",
			"updated_at": "2019-02-01 18:10:28"
		}],
		"dailyDatas": [{
			"datas": [{
				"val": "1935.6000",
				"key": "2019-06-19"
			}, {
				"val": "826.8000",
				"key": "2019-06-20"
			}, {
				"val": "368.4000",
				"key": "2019-06-21"
			}, {
				"val": "777.6000",
				"key": "2019-06-22"
			}, {
				"val": "4992.0000",
				"key": "2019-06-23"
			}, {
				"val": "3922.8000",
				"key": "2019-06-24"
			}, {
				"val": "4242.0000",
				"key": "2019-06-25"
			}, {
				"val": "5286.0000",
				"key": "2019-06-26"
			}],
			"key": "record_date",
			"val": "useValue",
			"unit": "kwh",
			"prop_area": 10000,
			"prop_num": 50,
			"name": "照明与插座",
			"gid": 1
		}, {
			"datas": [{
				"val": "3080.4000",
				"key": "2019-06-19"
			}, {
				"val": "1989.6000",
				"key": "2019-06-20"
			}, {
				"val": "693.6000",
				"key": "2019-06-21"
			}, {
				"val": "954.0000",
				"key": "2019-06-22"
			}, {
				"val": "4522.8000",
				"key": "2019-06-23"
			}, {
				"val": "3934.8000",
				"key": "2019-06-24"
			}, {
				"val": "3337.2000",
				"key": "2019-06-25"
			}, {
				"val": "5001.6000",
				"key": "2019-06-26"
			}],
			"key": "record_date",
			"val": "useValue",
			"unit": "kwh",
			"prop_area": 5000,
			"prop_num": 50,
			"name": "空调用电",
			"gid": 6
		}, {
			"datas": [{
				"val": "4017.6000",
				"key": "2019-06-19"
			}, {
				"val": "3618.0000",
				"key": "2019-06-20"
			}, {
				"val": "972.0000",
				"key": "2019-06-21"
			}, {
				"val": "669.6000",
				"key": "2019-06-22"
			}, {
				"val": "4210.8000",
				"key": "2019-06-23"
			}, {
				"val": "4398.0000",
				"key": "2019-06-24"
			}, {
				"val": "1960.8000",
				"key": "2019-06-25"
			}, {
				"val": "4940.4000",
				"key": "2019-06-26"
			}],
			"key": "record_date",
			"val": "useValue",
			"unit": "kwh",
			"prop_area": 5000,
			"prop_num": 50,
			"name": "动力用电",
			"gid": 11
		}, {
			"datas": [{
				"val": "11604.0000",
				"key": "2019-06-19"
			}, {
				"val": "8947.2000",
				"key": "2019-06-20"
			}, {
				"val": "2672.4000",
				"key": "2019-06-21"
			}, {
				"val": "2762.4000",
				"key": "2019-06-22"
			}, {
				"val": "10538.4000",
				"key": "2019-06-23"
			}, {
				"val": "10084.8000",
				"key": "2019-06-24"
			}, {
				"val": "5725.2000",
				"key": "2019-06-25"
			}, {
				"val": "11750.4000",
				"key": "2019-06-26"
			}],
			"key": "record_date",
			"val": "useValue",
			"unit": "kwh",
			"prop_area": 15000,
			"prop_num": 50,
			"name": "特殊用电",
			"gid": 15
		}],
		"summaryDatas": []
	}
}




var fake_data = {
	"/undefined/monitor/ajaxAmmeterGroupsSummaryDaily/undefined": {"code":"10000","msg":"success","sub_code":"","sub_msg":"success","result":{"from":"2019-06-19","to":"2019-06-26","building":{"id":1,"name":"大楼一号","capacity":12000,"capacity_text":"日耗电1.2w度","area":10000,"fee_policy":"{\r\n\t\"ammeter\": 0.85,\r\n\t\"watermeter\": 2.2,\r\n\t\"gasmeter\": 1.9,\r\n\t\"vapormeter\": 3.5\r\n}","status":"已建成","type":"政府项目","photo":"https:\/\/static-pvm.sunallies.com\/business.jpg","address":"浙江省宁波市宁海县金港路26号","latitude":29.304051000000001,"longitude":121.62177800000001,"location_id":61,"owner_id":1,"note":null,"created_at":"2019-02-11 18:00:36","updated_at":"2019-02-11 18:00:36"},"types":[{"id":9,"name":"能耗分项"},{"id":10,"name":"建筑区域"},{"id":11,"name":"组织机构"},{"id":12,"name":"自定义类别"}],"typeGroups":[{"id":1,"building_id":1,"group_type":9,"name":"照明与插座","parent_id":0,"prop_area":10000,"prop_num":50,"created_at":"2019-02-01 18:08:50","updated_at":"2019-02-01 18:08:50"},{"id":6,"building_id":1,"group_type":9,"name":"空调用电","parent_id":0,"prop_area":5000,"prop_num":50,"created_at":"2019-02-01 18:08:48","updated_at":"2019-02-01 18:08:48"},{"id":11,"building_id":1,"group_type":9,"name":"动力用电","parent_id":0,"prop_area":5000,"prop_num":50,"created_at":"2019-02-01 18:09:08","updated_at":"2019-02-01 18:09:08"},{"id":15,"building_id":1,"group_type":9,"name":"特殊用电","parent_id":0,"prop_area":15000,"prop_num":50,"created_at":"2019-02-01 18:09:13","updated_at":"2019-02-01 18:09:13"},{"id":2,"building_id":1,"group_type":9,"name":"照明","parent_id":1,"prop_area":10000,"prop_num":50,"created_at":"2019-02-01 18:10:04","updated_at":"2019-02-01 18:10:04"},{"id":3,"building_id":1,"group_type":9,"name":"插座","parent_id":1,"prop_area":10000,"prop_num":50,"created_at":"2019-02-01 18:10:04","updated_at":"2019-02-01 18:10:04"},{"id":4,"building_id":1,"group_type":9,"name":"公共区域照明","parent_id":1,"prop_area":10000,"prop_num":50,"created_at":"2019-02-01 18:10:04","updated_at":"2019-02-01 18:10:04"},{"id":5,"building_id":1,"group_type":9,"name":"室外景观照明","parent_id":1,"prop_area":10000,"prop_num":50,"created_at":"2019-02-01 18:10:04","updated_at":"2019-02-01 18:10:04"},{"id":7,"building_id":1,"group_type":9,"name":"冷热站","parent_id":6,"prop_area":5000,"prop_num":50,"created_at":"2019-02-01 18:10:14","updated_at":"2019-02-01 18:10:14"},{"id":8,"building_id":1,"group_type":9,"name":"空调末端","parent_id":6,"prop_area":5000,"prop_num":50,"created_at":"2019-02-01 18:10:14","updated_at":"2019-02-01 18:10:14"},{"id":9,"building_id":1,"group_type":9,"name":"净化系统","parent_id":6,"prop_area":5000,"prop_num":50,"created_at":"2019-02-01 18:10:14","updated_at":"2019-02-01 18:10:14"},{"id":10,"building_id":1,"group_type":9,"name":"大型独立空调","parent_id":6,"prop_area":5000,"prop_num":50,"created_at":"2019-02-01 18:10:14","updated_at":"2019-02-01 18:10:14"},{"id":12,"building_id":1,"group_type":9,"name":"电梯","parent_id":11,"prop_area":5000,"prop_num":50,"created_at":"2019-02-01 18:10:20","updated_at":"2019-02-01 18:10:20"},{"id":13,"building_id":1,"group_type":9,"name":"水泵","parent_id":11,"prop_area":5000,"prop_num":50,"created_at":"2019-02-01 18:10:20","updated_at":"2019-02-01 18:10:20"},{"id":14,"building_id":1,"group_type":9,"name":"通风机","parent_id":11,"prop_area":5000,"prop_num":50,"created_at":"2019-02-01 18:10:20","updated_at":"2019-02-01 18:10:20"},{"id":16,"building_id":1,"group_type":9,"name":"网络机房","parent_id":15,"prop_area":15000,"prop_num":50,"created_at":"2019-02-01 18:10:28","updated_at":"2019-02-01 18:10:28"},{"id":17,"building_id":1,"group_type":9,"name":"洗衣房","parent_id":15,"prop_area":15000,"prop_num":50,"created_at":"2019-02-01 18:10:28","updated_at":"2019-02-01 18:10:28"},{"id":18,"building_id":1,"group_type":9,"name":"厨房","parent_id":15,"prop_area":15000,"prop_num":50,"created_at":"2019-02-01 18:10:28","updated_at":"2019-02-01 18:10:28"},{"id":19,"building_id":1,"group_type":9,"name":"电话机房","parent_id":15,"prop_area":15000,"prop_num":50,"created_at":"2019-02-01 18:10:28","updated_at":"2019-02-01 18:10:28"},{"id":20,"building_id":1,"group_type":9,"name":"开闭站","parent_id":15,"prop_area":15000,"prop_num":50,"created_at":"2019-02-01 18:10:28","updated_at":"2019-02-01 18:10:28"},{"id":21,"building_id":1,"group_type":9,"name":"消防用电","parent_id":15,"prop_area":15000,"prop_num":50,"created_at":"2019-02-01 18:10:28","updated_at":"2019-02-01 18:10:28"},{"id":22,"building_id":1,"group_type":9,"name":"租户用电","parent_id":15,"prop_area":15000,"prop_num":50,"created_at":"2019-02-01 18:10:28","updated_at":"2019-02-01 18:10:28"},{"id":23,"building_id":1,"group_type":9,"name":"其他","parent_id":15,"prop_area":15000,"prop_num":50,"created_at":"2019-02-01 18:10:28","updated_at":"2019-02-01 18:10:28"}],"dailyDatas":[{"datas":[{"val":"1935.6000","key":"2019-06-19"},{"val":"826.8000","key":"2019-06-20"},{"val":"368.4000","key":"2019-06-21"},{"val":"777.6000","key":"2019-06-22"},{"val":"4992.0000","key":"2019-06-23"},{"val":"3922.8000","key":"2019-06-24"},{"val":"4242.0000","key":"2019-06-25"},{"val":"5286.0000","key":"2019-06-26"}],"key":"record_date","val":"useValue","unit":"kwh","prop_area":10000,"prop_num":50,"name":"照明与插座","gid":1},{"datas":[{"val":"3080.4000","key":"2019-06-19"},{"val":"1989.6000","key":"2019-06-20"},{"val":"693.6000","key":"2019-06-21"},{"val":"954.0000","key":"2019-06-22"},{"val":"4522.8000","key":"2019-06-23"},{"val":"3934.8000","key":"2019-06-24"},{"val":"3337.2000","key":"2019-06-25"},{"val":"5001.6000","key":"2019-06-26"}],"key":"record_date","val":"useValue","unit":"kwh","prop_area":5000,"prop_num":50,"name":"空调用电","gid":6},{"datas":[{"val":"4017.6000","key":"2019-06-19"},{"val":"3618.0000","key":"2019-06-20"},{"val":"972.0000","key":"2019-06-21"},{"val":"669.6000","key":"2019-06-22"},{"val":"4210.8000","key":"2019-06-23"},{"val":"4398.0000","key":"2019-06-24"},{"val":"1960.8000","key":"2019-06-25"},{"val":"4940.4000","key":"2019-06-26"}],"key":"record_date","val":"useValue","unit":"kwh","prop_area":5000,"prop_num":50,"name":"动力用电","gid":11},{"datas":[{"val":"11604.0000","key":"2019-06-19"},{"val":"8947.2000","key":"2019-06-20"},{"val":"2672.4000","key":"2019-06-21"},{"val":"2762.4000","key":"2019-06-22"},{"val":"10538.4000","key":"2019-06-23"},{"val":"10084.8000","key":"2019-06-24"},{"val":"5725.2000","key":"2019-06-25"},{"val":"11750.4000","key":"2019-06-26"}],"key":"record_date","val":"useValue","unit":"kwh","prop_area":15000,"prop_num":50,"name":"特殊用电","gid":15}],"summaryDatas":[]}},
	"/undefined/statistics/ajaxMeterSummary": {"code":"10000","msg":"success","sub_code":"","sub_msg":"success","result":{"from":"2019-06-19","to":"2019-06-26","building":{"id":1,"name":"大楼一号","capacity":12000,"capacity_text":"日耗电1.2w度","area":10000,"fee_policy":"{\r\n\t\"ammeter\": 0.85,\r\n\t\"watermeter\": 2.2,\r\n\t\"gasmeter\": 1.9,\r\n\t\"vapormeter\": 3.5\r\n}","status":"已建成","type":"政府项目","photo":"https:\/\/static-pvm.sunallies.com\/business.jpg","address":"浙江省宁波市宁海县金港路26号","latitude":29.304051000000001,"longitude":121.62177800000001,"location_id":61,"owner_id":1,"note":null,"created_at":"2019-02-11 18:00:36","updated_at":"2019-02-11 18:00:36"},"summaryData":{"internationalValue":0.14999999999999999,"total1Name":"总电量","total1Unit":"kwh","total1":"310303.2000","totalCompare1Month":"0","totalCompare1Year":"0","total2Name":"总水量","total2Unit":"吨","total2":0,"totalCompare2Month":0,"totalCompare2Year":0,"total3Name":"总燃气量","total3Unit":"立方米","total3":0,"totalCompare3Month":0,"totalCompare3Year":0,"total4Name":"总蒸汽量","total4Unit":"吨","total4":0,"totalCompare4Month":0,"totalCompare4Year":0},"chartDatas":{"ammeter":{"datas":[{"val":6522.8999999999996,"key":"2019-06-19"},{"val":6124.0799999999999,"key":"2019-06-20"},{"val":4129.9800000000005,"key":"2019-06-21"},{"val":6112.8600000000006,"key":"2019-06-22"},{"val":7569.4200000000001,"key":"2019-06-23"},{"val":9318.7200000000012,"key":"2019-06-24"},{"val":8973.9600000000009,"key":"2019-06-25"},{"val":10318.32,"key":"2019-06-26"}],"key":"record_date","val":"useValue","unit":"kwh","prop_area":10000,"name":"电量","area":10000,"fee_policy":0.84999999999999998},"watermeter":{"datas":[],"key":"record_date","val":"useValue","unit":"吨","prop_area":10000,"name":"水量","area":10000,"fee_policy":2.2000000000000002},"gasmeter":{"datas":[],"key":"record_date","val":"useValue","unit":"立方米","prop_area":10000,"name":"燃气量","area":10000,"fee_policy":1.8999999999999999},"vapormeter":{"datas":[],"key":"record_date","val":"useValue","unit":"吨","prop_area":10000,"name":"蒸汽费","area":10000,"fee_policy":3.5}},"totalVal":[{"name":"总电量","val":"310303.2000"},{"name":"总水量","val":0},{"name":"总燃气量","val":0},{"name":"总蒸汽量","val":0}],"dailyList":{"title":["日期","总电量","总电量密度","总水量","总水量密度","总燃气量","总燃气量密度","总蒸汽量","总蒸汽量密度"],"data":[["2019-06-19",6522.8999999999996,0.65000000000000002,0,0,0,0,0,0],["2019-06-20",6124.0799999999999,0.60999999999999999,0,0,0,0,0,0],["2019-06-21",4129.9799999999996,0.40999999999999998,0,0,0,0,0,0],["2019-06-22",6112.8599999999997,0.60999999999999999,0,0,0,0,0,0],["2019-06-23",7569.4200000000001,0.76000000000000001,0,0,0,0,0,0],["2019-06-24",9318.7199999999993,0.93000000000000005,0,0,0,0,0,0],["2019-06-25",8973.9599999999991,0.90000000000000002,0,0,0,0,0,0],["2019-06-26",10318.32,1.03,0,0,0,0,0,0]]}}},
	"/undefined/warning/ajaxWarning": {"code":"10000","msg":"success","sub_code":"","sub_msg":"success","result":{"from":"2019-06-01","to":"2019-06-26","types":[{"id":9,"name":"能耗分项"},{"id":10,"name":"建筑区域"},{"id":11,"name":"组织机构"},{"id":12,"name":"自定义类别"}],"warningSummary":[{"name":"电","unDealNum":2,"monthNum":2,"totalNum":5},{"name":"水","unDealNum":0,"monthNum":0,"totalNum":0},{"name":"天然气","unDealNum":0,"monthNum":0,"totalNum":0},{"name":"蒸汽","unDealNum":0,"monthNum":0,"totalNum":0},{"name":"室内环境","unDealNum":0,"monthNum":0,"totalNum":0}],"warningList":{"title":{"id":"序号","type":"报警类型","recorded_at":"报警时间","device_name":"设备名称","device_type":"设备类型","plant_use":"计划使用(kwh)","actual_use":"实际使用(kwh)","present":"超出比例"},"data":[{"id":10001,"type":"能耗计划","recorded_at":"2019-06-26 00:36:52","device_name":"2F 空调","device_type":"ammeter","plant_use":227,"actual_use":270,"present":"15.93%"},{"id":10002,"type":"能耗计划","recorded_at":"2019-06-25 00:55:54","device_name":"2F 空调","device_type":"ammeter","plant_use":112,"actual_use":143,"present":"21.68%"},{"id":10003,"type":"能耗计划","recorded_at":"2019-06-23 23:44:12","device_name":"2F 空调","device_type":"ammeter","plant_use":269,"actual_use":296,"present":"9.12%"},{"id":10004,"type":"能耗计划","recorded_at":"2019-06-22 23:55:06","device_name":"2F 空调","device_type":"ammeter","plant_use":419,"actual_use":431,"present":"2.78%"},{"id":10005,"type":"能耗计划","recorded_at":"2019-06-22 00:32:32","device_name":"2F 空调","device_type":"ammeter","plant_use":178,"actual_use":203,"present":"12.32%"},{"id":10006,"type":"能耗计划","recorded_at":"2019-06-21 01:03:59","device_name":"2F 空调","device_type":"ammeter","plant_use":254,"actual_use":302,"present":"15.89%"},{"id":10007,"type":"能耗计划","recorded_at":"2019-06-19 22:30:50","device_name":"2F 空调","device_type":"ammeter","plant_use":344,"actual_use":393,"present":"12.47%"},{"id":10008,"type":"能耗计划","recorded_at":"2019-06-19 00:51:43","device_name":"2F 空调","device_type":"ammeter","plant_use":59,"actual_use":101,"present":"41.58%"},{"id":10009,"type":"能耗计划","recorded_at":"2019-06-17 22:35:23","device_name":"2F 空调","device_type":"ammeter","plant_use":102,"actual_use":146,"present":"30.14%"}]}}},
	"/undefined/warning/ajaxAlertList": {"code":"10000","msg":"success","sub_code":"","sub_msg":"success","result":{"warningList":{"title":{"id":"序号","type_txt":"报警类型","name":"管理员","sendTo":"发送","from":"最早时间","to":"最晚时间","span":"时间间隔(分钟)","status":"状态"},"data":[{"id":1,"type":"email","type_txt":"邮件","name":"老王","sendTo":"sam@123.com","from":"08:00","to":"21:00","span":"60","status":"正常"},{"id":1,"type":"sms","type_txt":"短信","name":"老王","sendTo":"15821111111","from":"08:00","to":"21:00","span":"60","status":"正常"}]}}},
	"/undefined/settings/ajaxGroupTree": {"code":"10000","msg":"success","sub_code":"","sub_msg":"success","result":{"building":{"id":1,"name":"大楼一号","capacity":12000,"capacity_text":"日耗电1.2w度","area":10000,"fee_policy":"{\r\n\t\"ammeter\": 0.85,\r\n\t\"watermeter\": 2.2,\r\n\t\"gasmeter\": 1.9,\r\n\t\"vapormeter\": 3.5\r\n}","status":"已建成","type":"政府项目","photo":"https:\/\/static-pvm.sunallies.com\/business.jpg","address":"浙江省宁波市宁海县金港路26号","latitude":29.304051000000001,"longitude":121.62177800000001,"location_id":61,"owner_id":1,"note":null,"created_at":"2019-02-11 18:00:36","updated_at":"2019-02-11 18:00:36"},"groups":[{"id":"-9","name":"能耗分项","children":[{"id":1,"name":"照明与插座","children":[{"id":2,"name":"照明","children":[]},{"id":3,"name":"插座","children":[]},{"id":4,"name":"公共区域照明","children":[]},{"id":5,"name":"室外景观照明","children":[]}]},{"id":6,"name":"空调用电","children":[{"id":7,"name":"冷热站","children":[]},{"id":8,"name":"空调末端","children":[]},{"id":9,"name":"净化系统","children":[]},{"id":10,"name":"大型独立空调","children":[]}]},{"id":11,"name":"动力用电","children":[{"id":12,"name":"电梯","children":[]},{"id":13,"name":"水泵","children":[]},{"id":14,"name":"通风机","children":[]}]},{"id":15,"name":"特殊用电","children":[{"id":16,"name":"网络机房","children":[]},{"id":17,"name":"洗衣房","children":[]},{"id":18,"name":"厨房","children":[]},{"id":19,"name":"电话机房","children":[]},{"id":20,"name":"开闭站","children":[]},{"id":21,"name":"消防用电","children":[]},{"id":22,"name":"租户用电","children":[]},{"id":23,"name":"其他","children":[]}]}]},{"id":"-10","name":"建筑区域","children":[{"id":24,"name":"出租楼层","children":[{"id":25,"name":"1F","children":[]},{"id":26,"name":"2F","children":[]}]},{"id":28,"name":"自用楼层","children":[{"id":27,"name":"3F","children":[]}]}]},{"id":"-11","name":"组织机构","children":[{"id":34,"name":"商场","children":[{"id":37,"name":"A区","children":[]},{"id":38,"name":"B区","children":[]},{"id":39,"name":"C区","children":[]}]},{"id":35,"name":"地下车库","children":[{"id":40,"name":"A区","children":[]},{"id":41,"name":"B区","children":[]},{"id":42,"name":"C区","children":[]}]},{"id":36,"name":"办公楼层","children":[{"id":43,"name":"公共区域","children":[]},{"id":44,"name":"使用区域","children":[]}]}]},{"id":"-12","name":"自定义类别","children":[]}]}},
	"/undefined/settings/ajaxDeviceList": {"code":"10000","msg":"success","sub_code":"","sub_msg":"success","result":{"building":{"id":1,"name":"大楼一号","capacity":12000,"capacity_text":"日耗电1.2w度","area":10000,"fee_policy":"{\r\n\t\"ammeter\": 0.85,\r\n\t\"watermeter\": 2.2,\r\n\t\"gasmeter\": 1.9,\r\n\t\"vapormeter\": 3.5\r\n}","status":"已建成","type":"政府项目","photo":"https:\/\/static-pvm.sunallies.com\/business.jpg","address":"浙江省宁波市宁海县金港路26号","latitude":29.304051000000001,"longitude":121.62177800000001,"location_id":61,"owner_id":1,"note":null,"created_at":"2019-02-11 18:00:36","updated_at":"2019-02-11 18:00:36"},"collecors":[{"id":1,"build_id":"1","name":"采集器1","sn":"9414-0040-0000-0000-1040-b595-d040-0c48","status":"正常","from":"和远智能","sim":"","note":"通讯管理机","created_at":"2019-01-30 15:39:56","updated_at":"2019-01-30 15:39:56","type":"collector","type_txt":"采集器"},{"id":2,"build_id":"1","name":"采集器2","sn":"2e48-0040-0000-0000-1040-0d64-8000-0654","status":"正常","from":"和远智能","sim":"","note":"通讯管理机","created_at":"2019-01-30 16:37:31","updated_at":"2019-01-30 16:37:31","type":"collector","type_txt":"采集器"},{"id":3,"build_id":"1","name":"采集器3","sn":"3250-0040-0000-0000-1040-0d64-8080-0c4c","status":"正常","from":"和远智能","sim":"","note":"通讯管理机","created_at":"2019-01-30 16:37:34","updated_at":"2019-01-30 16:37:34","type":"collector","type_txt":"采集器"},{"id":4,"build_id":"1","name":"采集器4","sn":"841d-0040-0000-0000-1040-cd98-9880-0834","status":"正常","from":"和远智能","sim":"","note":"通讯管理机","created_at":"2019-01-31 13:53:02","updated_at":"2019-01-31 13:53:02","type":"collector","type_txt":"采集器"},{"id":5,"build_id":"1","name":"采集器5","sn":"e671-0040-0000-0000-1040-b595-d080-0d84","status":"正常","from":"ruff","sim":"","note":null,"created_at":"2019-01-30 16:10:24","updated_at":"2019-01-30 16:10:24","type":"collector","type_txt":"采集器"},{"id":6,"build_id":"1","name":"采集器6","sn":"841d-0040-0000-0000-1040-cd98-9880-0834","status":"正常","from":"ruff","sim":"","note":null,"created_at":"2019-01-30 16:10:46","updated_at":"2019-01-30 16:10:46","type":"collector","type_txt":"采集器"},{"id":7,"build_id":"1","name":"采集器7","sn":"2c7e-0040-0000-0000-1040-b595-d0c0-0c74","status":"正常","from":"ruff","sim":"","note":null,"created_at":"2019-01-30 16:11:17","updated_at":"2019-01-30 16:11:17","type":"collector","type_txt":"采集器"},{"id":8,"build_id":"1","name":"采集器8","sn":"\t\r\n0663-0040-0000-0000-1040-b595-d080-0fd4","status":"正常","from":"ruff","sim":"","note":null,"created_at":"2019-01-30 15:42:41","updated_at":"2019-01-30 15:42:41","type":"collector","type_txt":"采集器"},{"id":9,"build_id":"1","name":"采集器9","sn":"d02e-0040-0000-0000-1040-0d64-8040-0b70","status":"正常","from":"ruff","sim":"","note":null,"created_at":"2019-01-30 15:42:48","updated_at":"2019-01-30 15:42:48","type":"collector","type_txt":"采集器"},{"id":10,"build_id":"1","name":"采集器100","sn":"9601-0040-0000-0000-1040-8df0-70c0-0eb8","status":"正常","from":"和远智能","sim":"","note":"通讯管理机","created_at":"2019-01-30 15:51:37","updated_at":"2019-01-30 15:51:37","type":"collector","type_txt":"采集器"},{"id":11,"build_id":"1","name":"采集器101","sn":"2e27-0040-0000-0000-1040-551f-a0c0-0624","status":"正常","from":"和远智能","sim":"","note":"通讯管理机","created_at":"2019-01-30 15:51:54","updated_at":"2019-01-30 15:51:54","type":"collector","type_txt":"采集器"},{"id":12,"build_id":"1","name":"采集器102","sn":"ee68-0040-0000-0000-1040-8df0-70c0-0938","status":"正常","from":"ruff","sim":"","note":null,"created_at":"2019-01-30 15:52:08","updated_at":"2019-01-30 15:52:08","type":"collector","type_txt":"采集器"},{"id":16,"build_id":"1","name":"采集器200","sn":"2e27-0040-0000-0000-1040-551f-a0c0-0624","status":"正常","from":"ruff","sim":"","note":null,"created_at":"2019-01-15 14:25:00","updated_at":"2019-01-15 14:25:00","type":"collector","type_txt":"采集器"}],"meters":[{"bid":1,"id":1,"name":"主表1","sn":"10010866837","cid":1,"is_main":1,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":2,"name":"主表2","sn":"1541817142","cid":2,"is_main":1,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":3,"name":"主表3","sn":"1541817143","cid":2,"is_main":1,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":4,"name":"主表4","sn":"10015693022","cid":3,"is_main":1,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":5,"name":"1F 照明","sn":"0400419832","cid":6,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":6,"name":"2F 照明","sn":"0400422331","cid":6,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":7,"name":"3F 照明","sn":"0400422334","cid":6,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":8,"name":"1F 空调","sn":"0400422330","cid":6,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":9,"name":"2F 空调","sn":"0400422329","cid":6,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":10,"name":"3F 空调","sn":"10010810055","cid":10,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":11,"name":"电梯","sn":"10010807694","cid":11,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":12,"name":"水泵","sn":"10010810254","cid":12,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":13,"name":"通风机","sn":"10010810057","cid":13,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":14,"name":"1F 洗衣房","sn":"10010810083","cid":14,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":15,"name":"1F 厨房","sn":"10010810084","cid":14,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":16,"name":"3F 网络机房","sn":"10010810085","cid":14,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":17,"name":"3F 电话机房","sn":"10010810117","cid":14,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":18,"name":"1F 开闭站","sn":"10010813634","cid":14,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":19,"name":"1F 消防用电","sn":"0400422338","cid":6,"is_main":0,"rate":"120","note":null,"type":"ammeter","type_txt":"电表"},{"bid":1,"id":20,"name":"1F 租户用电","sn":"0400422336","cid":6,"is_main":0,"rate":"120","note":null,"type":"ammeter","type_txt":"电表"},{"bid":1,"id":21,"name":"2F 租户用电","sn":"0400422331","cid":6,"is_main":0,"rate":"120","note":null,"type":"ammeter","type_txt":"电表"},{"bid":1,"id":1,"name":"水表总","sn":"10015695087","cid":10,"is_main":1,"rate":"1","note":null,"type":"watermeter","type_txt":"水表"},{"bid":1,"id":2,"name":"水表高层","sn":"10010813636","cid":11,"is_main":0,"rate":"1","note":null,"type":"watermeter","type_txt":"水表"},{"bid":1,"id":3,"name":"水表底层","sn":"10006719828","cid":12,"is_main":0,"rate":"1","note":null,"type":"watermeter","type_txt":"水表"}],"collectorList":{"title":{"id":"编号","type_txt":"类型","name":"名称","sn":"SN","from":"厂家","sim":"sim","note":"备注"},"data":[{"id":1,"build_id":"1","name":"采集器1","sn":"9414-0040-0000-0000-1040-b595-d040-0c48","status":"正常","from":"和远智能","sim":"","note":"通讯管理机","created_at":"2019-01-30 15:39:56","updated_at":"2019-01-30 15:39:56","type":"collector","type_txt":"采集器"},{"id":2,"build_id":"1","name":"采集器2","sn":"2e48-0040-0000-0000-1040-0d64-8000-0654","status":"正常","from":"和远智能","sim":"","note":"通讯管理机","created_at":"2019-01-30 16:37:31","updated_at":"2019-01-30 16:37:31","type":"collector","type_txt":"采集器"},{"id":3,"build_id":"1","name":"采集器3","sn":"3250-0040-0000-0000-1040-0d64-8080-0c4c","status":"正常","from":"和远智能","sim":"","note":"通讯管理机","created_at":"2019-01-30 16:37:34","updated_at":"2019-01-30 16:37:34","type":"collector","type_txt":"采集器"},{"id":4,"build_id":"1","name":"采集器4","sn":"841d-0040-0000-0000-1040-cd98-9880-0834","status":"正常","from":"和远智能","sim":"","note":"通讯管理机","created_at":"2019-01-31 13:53:02","updated_at":"2019-01-31 13:53:02","type":"collector","type_txt":"采集器"},{"id":5,"build_id":"1","name":"采集器5","sn":"e671-0040-0000-0000-1040-b595-d080-0d84","status":"正常","from":"ruff","sim":"","note":null,"created_at":"2019-01-30 16:10:24","updated_at":"2019-01-30 16:10:24","type":"collector","type_txt":"采集器"},{"id":6,"build_id":"1","name":"采集器6","sn":"841d-0040-0000-0000-1040-cd98-9880-0834","status":"正常","from":"ruff","sim":"","note":null,"created_at":"2019-01-30 16:10:46","updated_at":"2019-01-30 16:10:46","type":"collector","type_txt":"采集器"},{"id":7,"build_id":"1","name":"采集器7","sn":"2c7e-0040-0000-0000-1040-b595-d0c0-0c74","status":"正常","from":"ruff","sim":"","note":null,"created_at":"2019-01-30 16:11:17","updated_at":"2019-01-30 16:11:17","type":"collector","type_txt":"采集器"},{"id":8,"build_id":"1","name":"采集器8","sn":"\t\r\n0663-0040-0000-0000-1040-b595-d080-0fd4","status":"正常","from":"ruff","sim":"","note":null,"created_at":"2019-01-30 15:42:41","updated_at":"2019-01-30 15:42:41","type":"collector","type_txt":"采集器"},{"id":9,"build_id":"1","name":"采集器9","sn":"d02e-0040-0000-0000-1040-0d64-8040-0b70","status":"正常","from":"ruff","sim":"","note":null,"created_at":"2019-01-30 15:42:48","updated_at":"2019-01-30 15:42:48","type":"collector","type_txt":"采集器"},{"id":10,"build_id":"1","name":"采集器100","sn":"9601-0040-0000-0000-1040-8df0-70c0-0eb8","status":"正常","from":"和远智能","sim":"","note":"通讯管理机","created_at":"2019-01-30 15:51:37","updated_at":"2019-01-30 15:51:37","type":"collector","type_txt":"采集器"},{"id":11,"build_id":"1","name":"采集器101","sn":"2e27-0040-0000-0000-1040-551f-a0c0-0624","status":"正常","from":"和远智能","sim":"","note":"通讯管理机","created_at":"2019-01-30 15:51:54","updated_at":"2019-01-30 15:51:54","type":"collector","type_txt":"采集器"},{"id":12,"build_id":"1","name":"采集器102","sn":"ee68-0040-0000-0000-1040-8df0-70c0-0938","status":"正常","from":"ruff","sim":"","note":null,"created_at":"2019-01-30 15:52:08","updated_at":"2019-01-30 15:52:08","type":"collector","type_txt":"采集器"},{"id":16,"build_id":"1","name":"采集器200","sn":"2e27-0040-0000-0000-1040-551f-a0c0-0624","status":"正常","from":"ruff","sim":"","note":null,"created_at":"2019-01-15 14:25:00","updated_at":"2019-01-15 14:25:00","type":"collector","type_txt":"采集器"}]},"meterList":{"title":{"id":"编号","type_txt":"类型","name":"名称","sn":"SN","is_main":"主表","rate":"倍率","note":"备注"},"data":[{"bid":1,"id":1,"name":"主表1","sn":"10010866837","cid":1,"is_main":1,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":2,"name":"主表2","sn":"1541817142","cid":2,"is_main":1,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":3,"name":"主表3","sn":"1541817143","cid":2,"is_main":1,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":4,"name":"主表4","sn":"10015693022","cid":3,"is_main":1,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":5,"name":"1F 照明","sn":"0400419832","cid":6,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":6,"name":"2F 照明","sn":"0400422331","cid":6,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":7,"name":"3F 照明","sn":"0400422334","cid":6,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":8,"name":"1F 空调","sn":"0400422330","cid":6,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":9,"name":"2F 空调","sn":"0400422329","cid":6,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":10,"name":"3F 空调","sn":"10010810055","cid":10,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":11,"name":"电梯","sn":"10010807694","cid":11,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":12,"name":"水泵","sn":"10010810254","cid":12,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":13,"name":"通风机","sn":"10010810057","cid":13,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":14,"name":"1F 洗衣房","sn":"10010810083","cid":14,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":15,"name":"1F 厨房","sn":"10010810084","cid":14,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":16,"name":"3F 网络机房","sn":"10010810085","cid":14,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":17,"name":"3F 电话机房","sn":"10010810117","cid":14,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":18,"name":"1F 开闭站","sn":"10010813634","cid":14,"is_main":0,"rate":"120","note":"","type":"ammeter","type_txt":"电表"},{"bid":1,"id":19,"name":"1F 消防用电","sn":"0400422338","cid":6,"is_main":0,"rate":"120","note":null,"type":"ammeter","type_txt":"电表"},{"bid":1,"id":20,"name":"1F 租户用电","sn":"0400422336","cid":6,"is_main":0,"rate":"120","note":null,"type":"ammeter","type_txt":"电表"},{"bid":1,"id":21,"name":"2F 租户用电","sn":"0400422331","cid":6,"is_main":0,"rate":"120","note":null,"type":"ammeter","type_txt":"电表"},{"bid":1,"id":1,"name":"水表总","sn":"10015695087","cid":10,"is_main":1,"rate":"1","note":null,"type":"watermeter","type_txt":"水表"},{"bid":1,"id":2,"name":"水表高层","sn":"10010813636","cid":11,"is_main":0,"rate":"1","note":null,"type":"watermeter","type_txt":"水表"},{"bid":1,"id":3,"name":"水表底层","sn":"10006719828","cid":12,"is_main":0,"rate":"1","note":null,"type":"watermeter","type_txt":"水表"}]}}},
	"/ajaxBuildingList": {"code":"10000","msg":"success","sub_code":"","sub_msg":"success","result":{"buildingList":{"title":{"photo":"图片","name":"名称","address":"地址","area":"面积"},"data":[{"id":1,"name":"大楼一号","capacity":12000,"capacity_text":"日耗电1.2w度","area":10000,"fee_policy":"{\r\n\t\"ammeter\": 0.85,\r\n\t\"watermeter\": 2.2,\r\n\t\"gasmeter\": 1.9,\r\n\t\"vapormeter\": 3.5\r\n}","status":"已建成","type":"政府项目","photo":"https:\/\/static-pvm.sunallies.com\/business.jpg","address":"浙江省宁波市宁海县金港路26号","latitude":29.304051000000001,"longitude":121.62177800000001,"location_id":61,"owner_id":1,"note":null,"created_at":"2019-02-11 18:00:36","updated_at":"2019-02-11 18:00:36"},{"id":2,"name":"大楼二号","capacity":900,"capacity_text":"节能演示","area":10000,"fee_policy":"{\r\n\t\"ammeter\": 0.85,\r\n\t\"watermeter\": 2.2,\r\n\t\"gasmeter\": 1.9,\r\n\t\"vapormeter\": 3.5\r\n}","status":"已建成","type":"测试项目","photo":"https:\/\/static-pvm.sunallies.com\/resident.jpg","address":"浙江省宁波市宁海县桃源街道","latitude":29.335837000000001,"longitude":121.45603,"location_id":null,"owner_id":1,"note":null,"created_at":"2019-02-11 17:59:17","updated_at":"2019-02-11 17:59:17"}]}}},
}