<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <style>
        .booking-container {
            display: flex;
            justify-content: center;
        }

        .dropdown {
            display: flex;
            gap: 25px;
        }

        form {
            display: flex;
            justify-content: center;
        }

        .states,
        .district {
            border: 2px solid antiquewhite;
            height: 30px;
            font-weight: bold;
            border-radius: 15px;
            background-color: antiquewhite;
            text-align: center;
            margin-bottom: 290px;
            margin-top: 220px;
            box-shadow: 1px 2px 6px 2px grey;
        }

        .district {
            width: 160px;
        }

        select {
            transition: max-height 0.5s ease;
            margin-bottom: 200px;
        }

        .district-container {
            display: none;
        }

        #attractions-container {
            border: 2px antiquewhite;
            border-radius: 10px;
            background-color: antiquewhite;
            box-shadow: 1px 2px 6px 2px grey;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            align-items: center;
            overflow: auto;
            height: 170px;
            margin-top: 160px;
            max-width: 150%;
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>
    <div class="booking-conatiner">
        <form action="">
            <div class="dropdown">
                <div class="state-container">
                    <label for="states">
                        <select name="states" id="states" onchange="updateDistricts()" class="states">
                            <option value="">Select State</option>
                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                            <option value="Assam">Assam</option>
                            <option value="Bihar">Bihar</option>
                            <option value="Chhattisgarh">Chhattisgarh</option>
                            <option value="Goa">Goa</option>
                            <option value="Gujarat">Gujarat</option>
                            <option value="Haryana">Haryana</option>
                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                            <option value="Jharkhand">Jharkhand</option>
                            <option value="Karnataka">Karnataka</option>
                            <option value="Kerala">Kerala</option>
                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                            <option value="Maharashtra">Maharashtra</option>
                            <option value="Manipur">Manipur</option>
                            <option value="Meghalaya">Meghalaya</option>
                            <option value="Mizoram">Mizoram</option>
                            <option value="Nagaland">Nagaland</option>
                            <option value="Odisha">Odisha</option>
                            <option value="Punjab">Punjab</option>
                            <option value="Rajasthan">Rajasthan</option>
                            <option value="Sikkim">Sikkim</option>
                            <option value="Tamil Nadu">Tamil Nadu</option>
                            <option value="Telangana">Telangana</option>
                            <option value="Tripura">Tripura</option>
                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                            <option value="Uttarakhand">Uttarakhand</option>
                            <option value="West Bengal">West Bengal</option>
                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                            <option value="Chandigarh">Chandigarh</option>
                            <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman
                                and
                                Diu
                            </option>
                            <option value="Lakshadweep">Lakshadweep</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Puducherry">Puducherry</option>
                            <option value="Ladakh">Ladakh</option>
                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                        </select>
                    </label>
                </div>
                <div class="district-container" id="district-container" style="display: none;">
                    <label for="districts">
                        <select name="districts" id="districtdropdown" class="district">
                            <option value="">Select District</option>
                        </select>
                    </label>
                </div>
                <div id="attractions-container" style="display: none;"></div>
            </div>

        </form>
    </div>
    <script>
        const districtsByState = {
            "Andhra Pradesh": ["Anantapur", "Chittoor", "East Godavari", "Guntur", "Krishna", "Kurnool", "Nellore", "Prakasam", "Srikakulam", "Visakhapatnam", "Vizianagaram", "West Godavari", "YSR Kadapa"],
            "Arunachal Pradesh": ["Anjaw", "Changlang", "East Kameng", "East Siang", "Kamle", "Kra Daadi", "Kurung Kumey", "Lepa Rada", "Lohit", "Longding", "Lower Dibang Valley", "Lower Siang", "Lower Subansiri", "Namsai", "Pakke Kessang", "Papum Pare", "Shi Yomi", "Siang", "Tawang", "Tirap", "Upper Dibang Valley", "Upper Siang", "Upper Subansiri", "West Kameng", "West Siang"],
            "Assam": ["Baksa", "Barpeta", "Biswanath", "Bongaigaon", "Cachar", "Charaideo", "Chirang", "Darrang", "Dhemaji", "Dhubri", "Dibrugarh", "Dima Hasao", "Goalpara", "Golaghat", "Hailakandi", "Hojai", "Jorhat", "Kamrup Metropolitan", "Kamrup", "Karbi Anglong", "Karimganj", "Kokrajhar", "Lakhimpur", "Majuli", "Morigaon", "Nagaon", "Nalbari", "Sivasagar", "Sonitpur", "South Salmara-Mankachar", "Tinsukia", "Udalguri", "West Karbi Anglong"],
            "Bihar": ["Araria", "Arwal", "Aurangabad", "Banka", "Begusarai", "Bhagalpur", "Bhojpur", "Buxar", "Darbhanga", "East Champaran (Motihari)", "Gaya", "Gopalganj", "Jamui", "Jehanabad", "Kaimur (Bhabua)", "Katihar", "Khagaria", "Kishanganj", "Lakhisarai", "Madhepura", "Madhubani", "Munger (Monghyr)", "Muzaffarpur", "Nalanda", "Nawada", "Patna", "Purnia (Purnea)", "Rohtas", "Saharsa", "Samastipur", "Saran", "Sheikhpura", "Sheohar", "Sitamarhi", "Siwan", "Supaul", "Vaishali", "West Champaran"],
            "Chhattisgarh": ["Balod", "Baloda Bazar", "Balrampur", "Bastar", "Bemetara", "Bijapur", "Bilaspur", "Dantewada (South Bastar)", "Dhamtari", "Durg", "Gariyaband", "Janjgir-Champa", "Jashpur", "Kabirdham (Kawardha)", "Kanker (North Bastar)", "Kondagaon", "Korba", "Korea (Koriya)", "Mahasamund", "Mungeli", "Narayanpur", "Raigarh", "Raipur", "Rajnandgaon", "Sukma", "Surajpur", "Surguja"],
            "Goa": ["North Goa", "South Goa"],
            "Gujarat": ["Ahmedabad", "Amreli", "Anand", "Aravalli", "Banaskantha (Palanpur)", "Bharuch", "Bhavnagar", "Botad", "Chhota Udepur", "Dahod", "Dang (Ahwa)", "Devbhoomi Dwarka", "Gandhinagar", "Gir Somnath", "Jamnagar", "Junagadh", "Kheda (Nadiad)", "Kutch", "Mahisagar", "Mehsana", "Morbi", "Narmada (Rajpipla)", "Navsari", "Panchmahal (Godhra)", "Patan", "Porbandar", "Rajkot", "Sabarkantha (Himmatnagar)", "Surat", "Surendranagar", "Tapi (Vyara)", "Vadodara", "Valsad"],
            "Haryana": ["Ambala", "Bhiwani", "Charkhi Dadri", "Faridabad", "Fatehabad", "Gurgaon", "Hisar", "Jhajjar", "Jind", "Kaithal", "Karnal", "Kurukshetra", "Mahendragarh", "Mewat", "Palwal", "Panchkula", "Panipat", "Rewari", "Rohtak", "Sirsa", "Sonipat", "Yamunanagar"],
            "Himachal Pradesh": ["Bilaspur", "Chamba", "Hamirpur", "Kangra", "Kinnaur", "Kullu", "Lahaul and Spiti", "Mandi", "Shimla", "Sirmaur (Sirmour)", "Solan", "Una"],
            "Jharkhand": ["Bokaro", "Chatra", "Deoghar", "Dhanbad", "Dumka", "East Singhbhum", "Garhwa", "Giridih", "Godda", "Gumla", "Hazaribagh", "Jamtara", "Khunti", "Koderma", "Latehar", "Lohardaga", "Pakur", "Palamu", "Ramgarh", "Ranchi", "Sahibganj", "Seraikela-Kharsawan", "Simdega", "West Singhbhum"],
            "Karnataka": ["Bagalkot", "Ballari (Bellary)", "Belagavi (Belgaum)", "Bengaluru (Bangalore) Rural", "Bengaluru (Bangalore) Urban", "Bidar", "Chamarajanagar", "Chikballapur", "Chikkamagaluru (Chikmagalur)", "Chitradurga", "Dakshina Kannada", "Davanagere", "Dharwad", "Gadag", "Hassan", "Haveri", "Kalaburagi (Gulbarga)", "Kodagu", "Kolar", "Koppal", "Mandya", "Mysuru (Mysore)", "Raichur", "Ramanagara", "Shivamogga (Shimoga)", "Tumakuru (Tumkur)", "Udupi", "Uttara Kannada (Karwar)", "Vijayapura (Bijapur)", "Yadgir"],
            "Kerala": ["Alappuzha", "Ernakulam", "Idukki", "Kannur", "Kasaragod", "Kollam", "Kottayam", "Kozhikode", "Malappuram", "Palakkad", "Pathanamthitta", "Thiruvananthapuram", "Thrissur", "Wayanad"],
            "Madhya Pradesh": ["Agar Malwa", "Alirajpur", "Anuppur", "Ashoknagar", "Balaghat", "Barwani", "Betul", "Bhind", "Bhopal", "Burhanpur", "Chhatarpur", "Chhindwara", "Damoh", "Datia", "Dewas", "Dhar", "Dindori", "Guna", "Gwalior", "Harda", "Hoshangabad", "Indore", "Jabalpur", "Jhabua", "Katni", "Khandwa", "Khargone", "Mandla", "Mandsaur", "Morena", "Narsinghpur", "Neemuch", "Panna", "Raisen", "Rajgarh", "Ratlam", "Rewa", "Sagar", "Satna", "Sehore", "Seoni", "Shahdol", "Shajapur", "Sheopur", "Shivpuri", "Sidhi", "Singrauli", "Tikamgarh", "Ujjain", "Umaria", "Vidisha"],
            "Maharashtra": ["Ahmednagar", "Akola", "Amravati", "Aurangabad", "Beed", "Bhandara", "Buldhana", "Chandrapur", "Dhule", "Gadchiroli", "Gondia", "Hingoli", "Jalgaon", "Jalna", "Kolhapur", "Latur", "Mumbai City", "Mumbai Suburban", "Nagpur", "Nanded", "Nandurbar", "Nashik", "Osmanabad", "Palghar", "Parbhani", "Pune", "Raigad", "Ratnagiri", "Sangli", "Satara", "Sindhudurg", "Solapur", "Thane", "Wardha", "Washim", "Yavatmal"],
            "Manipur": ["Bishnupur", "Chandel", "Churachandpur", "Imphal East", "Imphal West", "Jiribam", "Kakching", "Kamjong", "Kangpokpi", "Noney", "Pherzawl", "Senapati", "Tamenglong", "Tengnoupal", "Thoubal", "Ukhrul"],
            "Meghalaya": ["East Garo Hills", "East Jaintia Hills", "East Khasi Hills", "North Garo Hills", "Ri Bhoi", "South Garo Hills", "South West Garo Hills", "South West Khasi Hills", "West Garo Hills", "West Jaintia Hills", "West Khasi Hills"],
            "Mizoram": ["Aizawl", "Champhai", "Kolasib", "Lawngtlai", "Lunglei", "Mamit", "Saiha", "Serchhip"],
            "Nagaland": ["Dimapur", "Kiphire", "Kohima", "Longleng", "Mokokchung", "Mon", "Peren", "Phek", "Tuensang", "Wokha", "Zunheboto"],
            "Odisha": ["Angul", "Balangir", "Balasore", "Bargarh", "Bhadrak", "Boudh", "Cuttack", "Debagarh", "Dhenkanal", "Gajapati", "Ganjam", "Jagatsinghapur", "Jajpur", "Jharsuguda", "Kalahandi", "Kandhamal", "Kendrapara", "Kendujhar (Keonjhar)", "Khordha", "Koraput", "Malkangiri", "Mayurbhanj", "Nabarangpur", "Nayagarh", "Nuapada", "Puri", "Rayagada", "Sambalpur", "Sonepur", "Sundargarh"],
            "Punjab": ["Amritsar", "Barnala", "Bathinda", "Faridkot", "Fatehgarh Sahib", "Fazilka", "Ferozepur", "Gurdaspur", "Hoshiarpur", "Jalandhar", "Kapurthala", "Ludhiana", "Mansa", "Moga", "Mohali", "Muktsar", "Pathankot", "Patiala", "Rupnagar", "Sangrur", "Shaheed Bhagat Singh Nagar", "Tarn Taran"],
            "Rajasthan": ["Ajmer", "Alwar", "Banswara", "Baran", "Barmer", "Bharatpur", "Bhilwara", "Bikaner", "Bundi", "Chittorgarh", "Churu", "Dausa", "Dholpur", "Dungarpur", "Hanumangarh", "Jaipur", "Jaisalmer", "Jalore", "Jhalawar", "Jhunjhunu", "Jodhpur", "Karauli", "Kota", "Nagaur", "Pali", "Pratapgarh", "Rajsamand", "Sawai Madhopur", "Sikar", "Sirohi", "Sri Ganganagar", "Tonk", "Udaipur"],
            "Sikkim": ["East Sikkim", "North Sikkim", "South Sikkim", "West Sikkim"],
            "Tamil Nadu": ["Ariyalur", "Chengalpattu", "Chennai", "Coimbatore", "Cuddalore", "Dharmapuri", "Dindigul", "Erode", "Kallakurichi", "Kancheepuram", "Kanyakumari", "Karur", "Krishnagiri", "Madurai", "Nagapattinam", "Namakkal", "Nilgiris", "Perambalur", "Pudukkottai", "Ramanathapuram", "Ranipet", "Salem", "Sivaganga", "Tenkasi", "Thanjavur", "Theni", "Thoothukudi (Tuticorin)", "Tiruchirappalli", "Tirunelveli", "Tirupathur", "Tiruppur", "Tiruvallur", "Tiruvannamalai", "Tiruvarur", "Vellore", "Viluppuram", "Virudhunagar"],
            "Telangana": ["Adilabad", "Bhadradri Kothagudem", "Hyderabad", "Jagtial", "Jangaon", "Jayashankar Bhoopalpally", "Jogulamba Gadwal", "Kamareddy", "Karimnagar", "Khammam", "Kumuram Bheem Asifabad", "Mahabubabad", "Mahabubnagar", "Mancherial", "Medak", "Medchal-Malkajgiri", "Mulugu", "Nagarkurnool", "Nalgonda", "Narayanpet", "Nirmal", "Nizamabad", "Peddapalli", "Rajanna Sircilla", "Ranga Reddy", "Sangareddy", "Siddipet", "Suryapet", "Vikarabad", "Wanaparthy", "Warangal (Urban)", "Warangal Rural", "Yadadri Bhuvanagiri"],
            "Tripura": ["Dhalai", "Gomati", "Khowai", "North Tripura", "Sepahijala", "South Tripura", "Unakoti", "West Tripura"],
            "Uttar Pradesh": ["Agra", "Aligarh", "Ambedkar Nagar", "Amethi", "Amroha (J.P. Nagar)", "Auraiya", "Ayodhya (Faizabad)", "Azamgarh", "Baghpat", "Bahraich", "Ballia", "Balrampur", "Banda", "Barabanki", "Bareilly", "Basti", "Bhadohi", "Bijnor", "Budaun (Badaun)", "Bulandshahr", "Chandauli", "Chitrakoot", "Deoria", "Etah", "Etawah", "Farrukhabad", "Fatehpur", "Firozabad", "Gautam Buddh Nagar", "Ghaziabad", "Ghazipur", "Gonda", "Gorakhpur", "Hamirpur", "Hapur (Panchsheel Nagar)", "Hardoi", "Hathras", "Jalaun", "Jaunpur", "Jhansi", "Kannauj", "Kanpur Dehat", "Kanpur Nagar", "Kasganj", "Kaushambi", "Kushinagar (Padrauna)", "Lakhimpur - Kheri", "Lalitpur", "Lucknow", "Maharajganj", "Mahoba", "Mainpuri", "Mathura", "Mau", "Meerut", "Mirzapur", "Moradabad", "Muzaffarnagar", "Pilibhit", "Pratapgarh", "Prayagraj (Allahabad)", "Raebareli", "Rampur", "Saharanpur", "Sambhal (Bhim Nagar)", "Sant Kabir Nagar", "Shahjahanpur", "Shamli", "Shravasti", "Siddharthnagar", "Sitapur", "Sonbhadra", "Sultanpur", "Unnao", "Varanasi"],
            "Uttarakhand": ["Almora", "Bageshwar", "Chamoli", "Champawat", "Dehradun", "Haridwar", "Nainital", "Pauri Garhwal", "Pithoragarh", "Rudraprayag", "Tehri Garhwal", "Udham Singh Nagar", "Uttarkashi"],
            "West Bengal": ["Alipurduar", "Bankura", "Birbhum", "Cooch Behar", "Dakshin Dinajpur (South Dinajpur)", "Darjeeling", "Hooghly", "Howrah", "Jalpaiguri", "Jhargram", "Kalimpong", "Kolkata", "Malda", "Murshidabad", "Nadia", "North 24 Parganas", "Paschim Bardhaman (West Bardhaman)", "Paschim Medinipur (West Medinipur)", "Purba Bardhaman (East Bardhaman)", "Purba Medinipur (East Medinipur)", "Purulia", "South 24 Parganas", "Uttar Dinajpur (North Dinajpur)"],
            "Andaman and Nicobar Islands": ["Nicobar", "North and Middle Andaman", "South Andaman"],
            "Chandigarh": ["Chandigarh"],
            "Dadra and Nagar Haveli and Daman and Diu": ["Daman", "Diu", "Dadra and Nagar Haveli"],
            "Lakshadweep": ["Lakshadweep"],
            "Delhi": ["Central Delhi", "East Delhi", "New Delhi", "North Delhi", "North East Delhi", "North West Delhi", "Shahdara", "South Delhi", "South East Delhi", "South West Delhi", "West Delhi"],
            "Puducherry": ["Karaikal", "Mahe", "Puducherry", "Yanam"],
            "Ladakh": ["Kargil", "Leh"]
        };

        const touristAttractions = {
            // Andhra Pradesh
            'Visakhapatnam': [
                'Kailasagiri',
                'Ramakrishna Beach',
                'Submarine Museum',
                'Borra Caves',
                'Araku Valley',
                'Simhachalam Temple',
                'Indira Gandhi Zoological Park',
                'Yarada Beach'
            ],
            'Tirupati': [
                'Tirumala Venkateswara Temple',
                'Sri Kapileswara Swamy Temple',
                'Sri Govindarajaswami Temple',
                'Tirupati Park',
                'Chandragiri Fort',
                'Sri Kalyana Venkateswara Swamy Temple',
                'Talakona Waterfalls',
                'Sri Venkateswara National Park'
            ],

            // Arunachal Pradesh
            'Itanagar': [
                'Itanagar Wildlife Sanctuary',
                'Ganga Lake',
                'Tara Devi Temple',
                'Jawaharlal Nehru State Museum',
                'Rupa',
                'Sangti Valley',
                'Pangin',
                'Bomdila Monastery'
            ],
            'Tawang': [
                'Tawang Monastery',
                'Sela Pass',
                'Jaswant Garh War Memorial',
                'Tipi Orchid Sanctuary',
                'Nuranang Waterfalls',
                'Bap Teng Kang Waterfall',
                'Buddhist Monastery',
                'Penga Teng Tso Lake'
            ],

            // Assam
            'Guwahati': [
                'Kamakhya Temple',
                'Umananda Temple',
                'Assam State Museum',
                'Bhubaneswari Temple',
                'Guwahati Zoo',
                'Sukreswar Temple',
                'Peacock Island',
                'River Cruise on Brahmaputra'
            ],
            'Kaziranga': [
                'Kaziranga National Park',
                'Manas National Park',
                'Biodiversity Park',
                'Kaziranga Orchid Park',
                'Kohora Range',
                'Bagori Range',
                'Central Range',
                'Hollongapar Gibbon Sanctuary'
            ],

            // Bihar
            'Patna': [
                'Gandhi Maidan',
                'Patna Museum',
                'Mahavir Mandir',
                'Harman Mandi',
                'Bihar Museum',
                'Takht Sri Patna Sahib',
                'Golghar',
                'Sanjay Gandhi Jaivik Udyan'
            ],
            'Gaya': [
                'Mahabodhi Temple',
                'Bodh Gaya',
                'Japanese Temple',
                'Dungeshwari Cave Temples',
                'Tibetan Monastery',
                'Maha Bodhi Society Temple',
                'Sujata Stupa',
                'Gaya Pind Daan'
            ],

            // Chhattisgarh
            'Raipur': [
                'Vivekananda Sarovar',
                'Marine Drive',
                'Mahatma Gandhi Museum',
                'Nandanvan Jungle Safari',
                'Dudhadhari Monastery and Temple',
                'Sai Baba Temple',
                'Balaji Temple',
                'Kankali Temple'
            ],
            'Bilaspur': [
                'Achanakmar Wildlife Sanctuary',
                'Kardam Reservoir',
                'Ratanpur Fort',
                'Kanan Pendari Zoo',
                'Chaiturgarh Fort',
                'Baba Dham',
                'Mahakoshal Art Gallery',
                'Jatmai Temple'
            ],

            // Goa
            'Panaji': [
                'Church of Our Lady of the Immaculate Conception',
                'Dona Paula',
                'Miramar Beach',
                'Goa State Museum',
                'Mahalaxmi Temple',
                'Santa Monica Church',
                'Panaji Market',
                'Atal Sethu'
            ],
            'Margao': [
                'Colva Beach',
                'Margao Municipal Garden',
                'Church of the Holy Spirit',
                'Benaulim Beach',
                'Sesa Football Academy',
                'Rachol Seminary',
                'Mahalaxmi Temple',
                'Cortalim Church'
            ],

            // Gujarat
            'Ahmedabad': [
                'Sabarmati Ashram',
                'Kankaria Lake',
                'Adalaj Stepwell',
                'Jama Masjid',
                'Sidi Saiyyed Mosque',
                'Calico Museum of Textiles',
                'Manek Chowk',
                'Ahmedabad Water Park'
            ],
            'Gandhinagar': [
                'Akshardham Temple',
                'Gandhi Ashram',
                'Indroda Nature Park',
                'Sarita Udyan',
                'Gandhinagar Railway Station',
                'Children’s Park',
                'Swaminarayan Museum',
                'Sardar Patel Planetarium'
            ],

            // Haryana
            'Gurugram': [
                'Kingdom of Dreams',
                'Ambience Mall',
                'Sheetala Mata Mandir',
                'Sultanpur National Park',
                'Appu Ghar',
                'Cyber Hub',
                'MGF Metropolitan Mall',
                'Gurgaon Old City'
            ],
            'Faridabad': [
                'Baba Farid’s Tomb',
                'Surajkund',
                'Badkhal Lake',
                'Raja Nahar Singh Palace',
                'Wonderla Amusement Park',
                'Maharaja Surajmal Museum',
                'Raja Nahar Singh Palace',
                'Rose Garden'
            ],

            // Himachal Pradesh
            'Shimla': [
                'Mall Road',
                'Jakhoo Temple',
                'Christ Church',
                'Shimla Ridge',
                'The Viceregal Lodge',
                'Kufri',
                'Himalayan Bird Park',
                'Summer Hill'
            ],
            'Manali': [
                'Solang Valley',
                'Hadimba Temple',
                'Rohtang Pass',
                'Manu Temple',
                'Old Manali',
                'Vashisht Baths',
                'Beas River',
                'Mall Road'
            ],

            // Jharkhand
            'Ranchi': [
                'Jagannath Temple',
                'Hundru Falls',
                'Ranchi Lake',
                'Dassam Falls',
                'Pahari Mandir',
                'Tagore Hill',
                'Rock Garden',
                'Birsa Zoological Park'
            ],
            'Jamshedpur': [
                'Jubilee Park',
                'Tata Steel Zoological Park',
                'Bhuvaneshwari Temple',
                'Dalma Wildlife Sanctuary',
                'Sir Dorabji Tata Park',
                'Sakchi Gurudwara',
                'Tata Steel Adventure Foundation',
                'Go-Karting'
            ],

            // Karnataka
            'Bengaluru': [
                'Bangalore Palace',
                'Lalbagh Botanical Garden',
                'Vidhana Soudha',
                'Cubbon Park',
                'Tipu Sultan’s Summer Palace',
                'Bull Temple',
                'Nandi Hills',
                'Ulsoor Lake'
            ],
            'Mysuru': [
                'Mysore Palace',
                'Chamundi Hill',
                'Mysore Zoo',
                'St. Philomena’s Church',
                'Jaganmohan Palace',
                'Brindavan Gardens',
                'Karanji Lake',
                'Ranganathittu Bird Sanctuary'
            ],

            // Kerala
            'Kochi': [
                'Fort Kochi',
                'Mattancherry Palace',
                'Jew Town',
                'Chinese Fishing Nets',
                'Paradesi Synagogue',
                'Hill Palace Museum',
                'Marine Drive',
                'Willingdon Island'
            ],
            'Thiruvananthapuram': [
                'Padmanabhaswamy Temple',
                'Napier Museum',
                'Kuthiramalika Palace',
                'Shanghumukham Beach',
                'Sree Chitra Art Gallery',
                'Vellayani Lake',
                'Kanakakkunnu Palace',
                'Attukal Bhagavathy Temple'
            ],

            // Madhya Pradesh
            'Bhopal': [
                'Upper Lake',
                'Taj-ul-Masajid',
                'Bharat Bhavan',
                'Sanchi Stupa',
                'Birla Mandir',
                'State Museum',
                'Van Vihar National Park',
                'Gohar Mahal'
            ],
            'Indore': [
                'Rajwada',
                'Lal Baag Palace',
                'Indore Museum',
                'Sarafa Bazar',
                'Kanch Mandir',
                'Chhatri Baag',
                'Patalpani Waterfall',
                'Ralamandal Wildlife Sanctuary'
            ],

            // Maharashtra
            'Mumbai': [
                'Gateway of India',
                'Marine Drive',
                'Elephanta Caves',
                'Chhatrapati Shivaji Terminus',
                'Juhu Beach',
                'Haji Ali Dargah',
                'Sanjay Gandhi National Park',
                'Colaba Causeway'
            ],
            'Pune': [
                'Shaniwarwada',
                'Aga Khan Palace',
                'Sinhagad Fort',
                'Pataleshwar Cave Temple',
                'Raja Dinkar Kelkar Museum',
                'Osho Ashram',
                'Katraj Snake Park',
                'Lal Mahal'
            ],

            // Manipur
            'Imphal': [
                'Loktak Lake',
                'Kangla Fort',
                'Shree Shree Govindajee Temple',
                'Manipur State Museum',
                'Ima Keithel',
                'Japanese War Memorial',
                'Kangla Fort',
                'Red Hill'
            ],
            'Churachandpur': [
                'Churachandpur Hill',
                'Tuibong',
                'Pala Pha',
                'Henglep',
                'Rengkai',
                'Khuga Dam',
                'Pangaltang',
                'Sangaikot'
            ],

            // Meghalaya
            'Shillong': [
                'Umiam Lake',
                'Elephant Falls',
                'Shillong Peak',
                'Ward’s Lake',
                'Don Bosco Centre for Indigenous Cultures',
                'Laitlum Canyons',
                'Sweet Falls',
                'Mawlynnong Village'
            ],
            'Cherrapunji': [
                'Nohkalikai Falls',
                'Double Decker Living Root Bridge',
                'Mawsmai Cave',
                'Elephant Falls',
                'Seven Sisters Falls',
                'Dainthlen Falls',
                'Mawlynnong Village',
                'Thangkharang Park'
            ],

            // Mizoram
            'Aizawl': [
                'Mizoram State Museum',
                'Durtlang Hills',
                'Lunglei',
                'Baktawng Village',
                'Vantawng Falls',
                'Reiek',
                'Chungtui',
                'Tlawng River'
            ],
            'Lunglei': [
                'Tlawng River',
                'Khawnglung Wildlife Sanctuary',
                'Lunglei Bazar',
                'Khawnglung Wildlife Sanctuary',
                'Baktawng Village',
                'Vantawng Falls',
                'Durtlang Hills',
                'Sailam'
            ],

            // Nagaland
            'Kohima': [
                'Kohima War Cemetery',
                'Dzükou Valley',
                'Kohima Cathedral',
                'Naga Heritage Village',
                'State Museum',
                'Japfu Peak',
                'Touphema Village',
                'Khonoma Village'
            ],
            'Dimapur': [
                'Kachari Ruins',
                'Dimapur Jain Temple',
                'Nagaland Science Centre',
                'Ruzhukhrie',
                'Shiv Mandir',
                'Hemis Monastery',
                'Saramati Peak',
                'Green Park'
            ],

            // Odisha
            'Bhubaneswar': [
                'Lingaraj Temple',
                'Udayagiri and Khandagiri Caves',
                'Raja Rani Temple',
                'Mukteshwar Temple',
                'Nandankanan Zoological Park',
                'Dhauli Giri Hills',
                'State Museum',
                'Buddhist Temple'
            ],
            'Puri': [
                'Jagannath Temple',
                'Puri Beach',
                'Konark Sun Temple',
                'Chilika Lake',
                'Satyabadi',
                'Raghurajpur',
                'Puri Lighthouse',
                'Gundicha Temple'
            ],

            // Punjab
            'Amritsar': [
                'Golden Temple',
                'Jallianwala Bagh',
                'Wagah Border',
                'Partition Museum',
                'Maharaja Ranjit Singh Museum',
                'Ram Bagh Gardens',
                'Durgiana Temple',
                'Gobindgarh Fort'
            ],
            'Ludhiana': [
                'Punjab Agricultural University Museum',
                'Ludhiana Museum',
                'Raja Dorabjis Palace',
                'Shri Satguru Jagjit Singh Memorial',
                'Gurdwara Charan Kamal',
                'Gurdwara Dukh Niwaran Sahib',
                'Gurdwara Nanaksar',
                'Clock Tower'
            ],

            // Rajasthan
            'Jaipur': [
                'Amber Fort',
                'City Palace',
                'Hawa Mahal',
                'Jantar Mantar',
                'Nahargarh Fort',
                'Jaigarh Fort',
                'Jal Mahal',
                'Albert Hall Museum'
            ],
            'Udaipur': [
                'City Palace',
                'Lake Pichola',
                'Jag Mandir',
                'Saheliyon Ki Bari',
                'Bagore Ki Haveli',
                'Fateh Sagar Lake',
                'Jagdish Temple',
                'Sajjangarh Palace'
            ],

            // Sikkim
            'Gangtok': [
                'Rumtek Monastery',
                'Tsomgo Lake',
                'Buddha Park',
                'Enchey Monastery',
                'Ganesh Tok',
                'Namgyal Institute of Tibetology',
                'Flower Exhibition Centre',
                'Tashi View Point'
            ],
            'Pelling': [
                'Pemayangtse Monastery',
                'Khecheopalri Lake',
                'Rabdentse Ruins',
                'Sangachoeling Monastery',
                'Yuksom',
                'Kanchenjunga Falls',
                'Khangchendzonga National Park',
                'Pelling Skywalk'
            ],

            // Tamil Nadu
            'Chennai': [
                'Marina Beach',
                'Kapaleeshwarar Temple',
                'Fort St. George',
                'Government Museum',
                'San Thome Basilica',
                'MGR Memorial',
                'Valluvar Kottam',
                'Guindy National Park'
            ],
            'Madurai': [
                'Meenakshi Amman Temple',
                'Thirumalai Nayakkar Palace',
                'Gandhi Museum',
                'Alagar Kovil',
                'Pudhu Mandapam',
                'Sri Ramakrishna Mission',
                'Koodal Azhagar Temple',
                'Tirupparankundram Temple'
            ],

            // Telangana
            'Hyderabad': [
                'Charminar',
                'Golconda Fort',
                'Hussain Sagar Lake',
                'Ramoji Film City',
                'Salar Jung Museum',
                'Qutb Shahi Tombs',
                'Birla Mandir',
                'Shilparamam'
            ],
            'Warangal': [
                'Warangal Fort',
                'Thousand Pillar Temple',
                'Ramappa Temple',
                'Kakatiya Musical Garden',
                'Borgi Lake',
                'Padmakshi Temple',
                'Warangal Zoo',
                'Siddheshwara Temple'
            ],

            // Tripura
            'Agartala': [
                'Ujjayanta Palace',
                'Neermahal Palace',
                'Tripura Sundari Temple',
                'Jampui Hills',
                'Sepahijala Wildlife Sanctuary',
                'Rudrasagar Lake',
                'Kailashahar',
                'Bhuvaneswari Temple'
            ],
            'Unakoti': [
                'Unakoti Rock Cut Sculptures',
                'Kailashahar',
                'Jampui Hills',
                'Unakoti Temple',
                'Rudrasagar Lake',
                'Sepahijala Wildlife Sanctuary',
                'Kailashahar',
                'Bhuvaneswari Temple'
            ],

            // Uttar Pradesh
            'Agra': [
                'Taj Mahal',
                'Agra Fort',
                'Fatehpur Sikri',
                'Itmad-ud-Daulah',
                'Mehtab Bagh',
                'Jama Masjid',
                'Ram Bagh',
                'Mariams Tomb'
            ],
            'Lucknow': [
                'Bara Imambara',
                'Chota Imambara',
                'Rumi Darwaza',
                'Ambedkar Memorial Park',
                'La Martiniere College',
                'Clock Tower',
                'Shah Najaf Imambara',
                'Husainabad Clock Tower'
            ]
        };

       
        function createCheckboxes(attractions) {
            const container = document.getElementById('attractions-container');
            container.innerHTML = ''; 

            attractions.forEach(attraction => {
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.id = attraction;
                checkbox.value = attraction;
                checkbox.name = 'attractions';

                const label = document.createElement('label');
                label.htmlFor = attraction;
                label.textContent = attraction;

                const br = document.createElement('br'); 

                container.appendChild(checkbox);
                container.appendChild(label);
                container.appendChild(br);
            });

            
            container.style.display = 'block';
        }

        function updateAttractions() {
            const districtDropdown = document.getElementById('districtdropdown');
            const selectedDistrict = districtDropdown.value;

            console.log('Selected District:', selectedDistrict);

            if (selectedDistrict) {
                const attractions = touristAttractions[selectedDistrict];
                if (attractions) {
                    createCheckboxes(attractions);
                } else {
                    console.error('No attractions found for district:', selectedDistrict); 
                    document.getElementById('attractions-container').style.display = 'none';
                }
            } else {
                document.getElementById('attractions-container').style.display = 'none'; 
            }
        }

        
        document.getElementById('districtdropdown').addEventListener('change', updateAttractions);

        
        function updateDistricts() {
            const stateDropdown = document.getElementById("states");
            const districtDropdown = document.getElementById("districtdropdown");
            const districtcontainer = document.getElementById("district-container");
            const selectedState = stateDropdown.value;

            console.log('Selected State:', selectedState); 

            
            districtDropdown.innerHTML = '<option value="">Select District</option>';

            if (selectedState && districtsByState[selectedState]) {
                districtsByState[selectedState].forEach(district => {
                    const option = document.createElement("option");
                    option.value = district;
                    option.textContent = district;
                    districtDropdown.appendChild(option);
                });
                districtcontainer.style.display = "block";
            } else {
                districtcontainer.style.display = "none";
            }

            // Hide attractions container when state is changed
            document.getElementById('attractions-container').style.display = 'none';
        }

        // Add event listener to update districts on state change
        document.getElementById('states').addEventListener('change', updateDistricts);
    </script>
    <?php include('footer.php'); ?>
</body>

</html>