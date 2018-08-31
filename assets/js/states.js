var union_arr = new Array("EAST KENYA UNION CONFERENCE","WEST KENYA UNION CONFERENCE");

var s_a = new Array();
s_a[0]="";
s_a[1]="Central Kenya Conference| Central Rift Valley Conference|Kenya Coast Field|Nyamira Conference|South Kenya Conference";
s_a[2]="Central Nyanza Conference| Greater Rift Valley Conference|Kenya Lake Conference|North West Kenya Conference| Ranen Conference";

function print_union(union_id){
	// given the id of the <select> tag as function argument, it inserts <option> tags
	var option_str = document.getElementById(union_id);
	option_str.length=0;
	option_str.options[0] = new Option('Select Union','');
	option_str.selectedIndex = 0;
	for (var i=0; i<union_arr.length; i++) {
		option_str.options[option_str.length] = new Option(union_arr[i],union_arr[i]);
	}
}

function print_conf(conf_id, conf_index){
	var option_str = document.getElementById(conf_id);
	option_str.length=0;	// Fixed by Julian Woods
	option_str.options[0] = new Option('Select Conference','');
	option_str.selectedIndex = 0;
	var conf_arr = s_a[conf_index].split("|");
	for (var i=0; i<conf_arr.length; i++) {
		option_str.options[option_str.length] = new Option(conf_arr[i],conf_arr[i]);
	}
}
