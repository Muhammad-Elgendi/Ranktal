var latitude,
    longitude,
    loc,
    enabled,
    background;
var settings = [], setting = {}, ac = [];
var showMap = false;

var google_sites = [
  {
    "name": "Germany",
    "gl": "DE",
    "lang": "Deutsch",
    "hl": "de",
    "dir": "ltr",
    "url": "https://www.google.de/search"
  },
  {
    "name": "Spain",
    "gl": "ES",
    "lang": "español",
    "hl": "es",
    "dir": "ltr",
    "url": "https://www.google.es/search"
  },
  {
    "name": "United States",
    "gl": "US",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.us/search"
  },
  {
    "name": "United Kingdom",
    "gl": "GB",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.uk/search"
  },
  {
    "name": "India",
    "gl": "IN",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.in/search"
  },
  {
    "name": "Australia",
    "gl": "AU",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.au/search"
  },
  {
    "name": "Austria",
    "gl": "AT",
    "lang": "Deutsch",
    "hl": "de",
    "dir": "ltr",
    "url": "https://www.google.at/search"
  },
  {
    "name": "Belgium",
    "gl": "BE",
    "lang": "Nederlands",
    "hl": "nl",
    "dir": "ltr",
    "url": "https://www.google.be/search"
  },
  {
    "name": "Belgium",
    "gl": "BE",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.be/search"
  },
  {
    "name": "Belgium",
    "gl": "BE",
    "lang": "Deutsch",
    "hl": "de",
    "dir": "ltr",
    "url": "https://www.google.be/search"
  },
  {
    "name": "Belgium",
    "gl": "BE",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.be/search"
  },
  {
    "name": "Ireland",
    "gl": "IE",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.ie/search"
  },
  {
    "name": "Netherlands",
    "gl": "NL",
    "lang": "Nederlands",
    "hl": "nl",
    "dir": "ltr",
    "url": "https://www.google.nl/search"
  },
  {
    "name": "Canada",
    "gl": "CA",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.ca/search"
  },
  {
    "name": "Canada",
    "gl": "CA",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.ca/search"
  },
  {
    "name": "Afghanistan",
    "gl": "AF",
    "lang": "پښتو",
    "hl": "ps",
    "dir": "rtl",
    "url": "https://www.google.com.af/search"
  },
  {
    "name": "Afghanistan",
    "gl": "AF",
    "lang": "فارسی",
    "hl": "fa",
    "dir": "rtl",
    "url": "https://www.google.com.af/search"
  },
  {
    "name": "Albania",
    "gl": "AL",
    "lang": "Shqip",
    "hl": "sq",
    "dir": "ltr",
    "url": "https://www.google.al/search"
  },
  {
    "name": "Albania",
    "gl": "AL",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.al/search"
  },
  {
    "name": "Algeria",
    "gl": "DZ",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.dz/search"
  },
  {
    "name": "Algeria",
    "gl": "DZ",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.dz/search"
  },
  {
    "name": "American Samoa",
    "gl": "AS",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.as/search"
  },
  {
    "name": "Angola",
    "gl": "AO",
    "lang": "Português (Portugal)",
    "hl": "pt-PT",
    "dir": "ltr",
    "url": "https://www.google.co.ao/search"
  },
  {
    "name": "Angola",
    "gl": "AO",
    "lang": "Kongo",
    "hl": "kg",
    "dir": "ltr",
    "url": "https://www.google.co.ao/search"
  },
  {
    "name": "Anguilla",
    "gl": "AI",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.off.ai/search"
  },
  {
    "name": "Antigua & Barbuda",
    "gl": "AG",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.ag/search"
  },
  {
    "name": "Argentina",
    "gl": "AR",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.com.ar/search"
  },
  {
    "name": "Armenia",
    "gl": "AM",
    "lang": "հայերեն",
    "hl": "hy",
    "dir": "ltr",
    "url": "https://www.google.am/search"
  },
  {
    "name": "Armenia",
    "gl": "AM",
    "lang": "русский",
    "hl": "ru",
    "dir": "ltr",
    "url": "https://www.google.am/search"
  },
  {
    "name": "Azerbaijan",
    "gl": "AZ",
    "lang": "Azərbaycan dili",
    "hl": "az",
    "dir": "ltr",
    "url": "https://www.google.az/search"
  },
  {
    "name": "Azerbaijan",
    "gl": "AZ",
    "lang": "русский",
    "hl": "ru",
    "dir": "ltr",
    "url": "https://www.google.az/search"
  },
  {
    "name": "Bahamas",
    "gl": "BS",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.bs/search"
  },
  {
    "name": "Bahrain",
    "gl": "BH",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.com.bh/search"
  },
  {
    "name": "Bahrain",
    "gl": "BH",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.bh/search"
  },
  {
    "name": "Bangladesh",
    "gl": "BD",
    "lang": "বাংলা",
    "hl": "bn",
    "dir": "ltr",
    "url": "https://www.google.com.bd/search"
  },
  {
    "name": "Bangladesh",
    "gl": "BD",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.bd/search"
  },
  {
    "name": "Belarus",
    "gl": "BY",
    "lang": "Беларуская",
    "hl": "be",
    "dir": "ltr",
    "url": "https://www.google.by/search"
  },
  {
    "name": "Belarus",
    "gl": "BY",
    "lang": "русский",
    "hl": "ru",
    "dir": "ltr",
    "url": "https://www.google.by/search"
  },
  {
    "name": "Benin",
    "gl": "BJ",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.bj/search"
  },
  {
    "name": "Benin",
    "gl": "BJ",
    "lang": "Èdè Yorùbá",
    "hl": "yo",
    "dir": "ltr",
    "url": "https://www.google.bj/search"
  },
  {
    "name": "Bolivia",
    "gl": "BO",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.com.bo/search"
  },
  {
    "name": "Bolivia",
    "gl": "BO",
    "lang": "Quechua",
    "hl": "qu",
    "dir": "ltr",
    "url": "https://www.google.com.bo/search"
  },
  {
    "name": "Bosnia & Herzegovina",
    "gl": "BA",
    "lang": "bosanski",
    "hl": "bs",
    "dir": "ltr",
    "url": "https://www.google.ba/search"
  },
  {
    "name": "Bosnia & Herzegovina",
    "gl": "BA",
    "lang": "српски",
    "hl": "sr",
    "dir": "ltr",
    "url": "https://www.google.ba/search"
  },
  {
    "name": "Bosnia & Herzegovina",
    "gl": "BA",
    "lang": "hrvatski",
    "hl": "hr",
    "dir": "ltr",
    "url": "https://www.google.ba/search"
  },
  {
    "name": "Botswana",
    "gl": "BW",
    "lang": "Setswana",
    "hl": "tn",
    "dir": "ltr",
    "url": "https://www.google.co.bw/search"
  },
  {
    "name": "Botswana",
    "gl": "BW",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.bw/search"
  },
  {
    "name": "Brazil",
    "gl": "BR",
    "lang": "Português (Brasil)",
    "hl": "pt-BR",
    "dir": "ltr",
    "url": "https://www.google.com.br/search"
  },
  {
    "name": "British Virgin Islands",
    "gl": "VG",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.vg/search"
  },
  {
    "name": "Brunei",
    "gl": "BN",
    "lang": "Melayu",
    "hl": "ms",
    "dir": "ltr",
    "url": "https://www.google.com.bn/search"
  },
  {
    "name": "Brunei",
    "gl": "BN",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.bn/search"
  },
  {
    "name": "Brunei",
    "gl": "BN",
    "lang": "中文(简体)",
    "hl": "zh-CN",
    "dir": "ltr",
    "url": "https://www.google.com.bn/search"
  },
  {
    "name": "Bulgaria",
    "gl": "BG",
    "lang": "български",
    "hl": "bg",
    "dir": "ltr",
    "url": "https://www.google.bg/search"
  },
  {
    "name": "Burkina Faso",
    "gl": "BF",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.bf/search"
  },
  {
    "name": "Burundi",
    "gl": "BI",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.bi/search"
  },
  {
    "name": "Burundi",
    "gl": "BI",
    "lang": "Kiswahili",
    "hl": "sw",
    "dir": "ltr",
    "url": "https://www.google.bi/search"
  },
  {
    "name": "Burundi",
    "gl": "BI",
    "lang": "ikirundi",
    "hl": "rn",
    "dir": "ltr",
    "url": "https://www.google.bi/search"
  },
  {
    "name": "Cambodia",
    "gl": "KH",
    "lang": "ខ្មែរ",
    "hl": "km",
    "dir": "ltr",
    "url": "https://www.google.com.kh/search"
  },
  {
    "name": "Cambodia",
    "gl": "KH",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.kh/search"
  },
  {
    "name": "Cameroon",
    "gl": "CM",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.cm/search"
  },
  {
    "name": "Cameroon",
    "gl": "CM",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.cm/search"
  },
  {
    "name": "Cape Verde",
    "gl": "CV",
    "lang": "Português (Portugal)",
    "hl": "pt-PT",
    "dir": "ltr",
    "url": "https://www.google.cv/search"
  },
  {
    "name": "Chad",
    "gl": "TD",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.td/search"
  },
  {
    "name": "Chad",
    "gl": "TD",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.td/search"
  },
  {
    "name": "Chile",
    "gl": "CL",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.cl/search"
  },
  {
    "name": "Colombia",
    "gl": "CO",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.com.co/search"
  },
  {
    "name": "Congo - Brazzaville",
    "gl": "CG",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.cg/search"
  },
  {
    "name": "Congo - Brazzaville",
    "gl": "CG",
    "lang": "Lingala",
    "hl": "ln",
    "dir": "ltr",
    "url": "https://www.google.cg/search"
  },
  {
    "name": "Congo - Brazzaville",
    "gl": "CG",
    "lang": "Kongo",
    "hl": "kg",
    "dir": "ltr",
    "url": "https://www.google.cg/search"
  },
  {
    "name": "Congo - Kinshasa",
    "gl": "CD",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.cd/search"
  },
  {
    "name": "Congo - Kinshasa",
    "gl": "CD",
    "lang": "Kiswahili",
    "hl": "sw",
    "dir": "ltr",
    "url": "https://www.google.cd/search"
  },
  {
    "name": "Congo - Kinshasa",
    "gl": "CD",
    "lang": "Lingala",
    "hl": "ln",
    "dir": "ltr",
    "url": "https://www.google.cd/search"
  },
  {
    "name": "Congo - Kinshasa",
    "gl": "CD",
    "lang": "Luo",
    "hl": "ach",
    "dir": "ltr",
    "url": "https://www.google.cd/search"
  },
  {
    "name": "Congo - Kinshasa",
    "gl": "CD",
    "lang": "Tshiluba",
    "hl": "lua",
    "dir": "ltr",
    "url": "https://www.google.cd/search"
  },
  {
    "name": "Congo - Kinshasa",
    "gl": "CD",
    "lang": "Kongo",
    "hl": "kg",
    "dir": "ltr",
    "url": "https://www.google.cd/search"
  },
  {
    "name": "Cook Islands",
    "gl": "CK",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.ck/search"
  },
  {
    "name": "Costa Rica",
    "gl": "CR",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.co.cr/search"
  },
  {
    "name": "Costa Rica",
    "gl": "CR",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.cr/search"
  },
  {
    "name": "Croatia",
    "gl": "HR",
    "lang": "hrvatski",
    "hl": "hr",
    "dir": "ltr",
    "url": "https://www.google.hr/search"
  },
  {
    "name": "Cyprus",
    "gl": "CY",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.cy/search"
  },
  {
    "name": "Cyprus",
    "gl": "CY",
    "lang": "Ελληνικά",
    "hl": "el",
    "dir": "ltr",
    "url": "https://www.google.com.cy/search"
  },
  {
    "name": "Cyprus",
    "gl": "CY",
    "lang": "Türkçe",
    "hl": "tr",
    "dir": "ltr",
    "url": "https://www.google.com.cy/search"
  },
  {
    "name": "Czechia",
    "gl": "CZ",
    "lang": "čeština",
    "hl": "cs",
    "dir": "ltr",
    "url": "https://www.google.cz/search"
  },
  {
    "name": "Denmark",
    "gl": "DK",
    "lang": "Dansk",
    "hl": "da",
    "dir": "ltr",
    "url": "https://www.google.dk/search"
  },
  {
    "name": "Denmark",
    "gl": "DK",
    "lang": "Føroyskt",
    "hl": "fo",
    "dir": "ltr",
    "url": "https://www.google.dk/search"
  },
  {
    "name": "Djibouti",
    "gl": "DJ",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.dj/search"
  },
  {
    "name": "Djibouti",
    "gl": "DJ",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.dj/search"
  },
  {
    "name": "Djibouti",
    "gl": "DJ",
    "lang": "Soomaali",
    "hl": "so",
    "dir": "ltr",
    "url": "https://www.google.dj/search"
  },
  {
    "name": "Dominica",
    "gl": "DM",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.dm/search"
  },
  {
    "name": "Dominican Republic",
    "gl": "DO",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.com.do/search"
  },
  {
    "name": "Ecuador",
    "gl": "EC",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.com.ec/search"
  },
  {
    "name": "Egypt",
    "gl": "EG",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.com.eg/search"
  },
  {
    "name": "Egypt",
    "gl": "EG",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.eg/search"
  },
  {
    "name": "El Salvador",
    "gl": "SV",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.com.sv/search"
  },
  {
    "name": "Estonia",
    "gl": "EE",
    "lang": "eesti",
    "hl": "et",
    "dir": "ltr",
    "url": "https://www.google.ee/search"
  },
  {
    "name": "Estonia",
    "gl": "EE",
    "lang": "русский",
    "hl": "ru",
    "dir": "ltr",
    "url": "https://www.google.ee/search"
  },
  {
    "name": "Fiji",
    "gl": "FJ",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.fj/search"
  },
  {
    "name": "Finland",
    "gl": "FI",
    "lang": "suomi",
    "hl": "fi",
    "dir": "ltr",
    "url": "https://www.google.fi/search"
  },
  {
    "name": "Finland",
    "gl": "FI",
    "lang": "svenska",
    "hl": "sv",
    "dir": "ltr",
    "url": "https://www.google.fi/search"
  },
  {
    "name": "France",
    "gl": "FR",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.fr/search"
  },
  {
    "name": "Gabon",
    "gl": "GA",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.ga/search"
  },
  {
    "name": "Gambia",
    "gl": "GM",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.gm/search"
  },
  {
    "name": "Gambia",
    "gl": "GM",
    "lang": "Wolof",
    "hl": "wo",
    "dir": "ltr",
    "url": "https://www.google.gm/search"
  },
  {
    "name": "Georgia",
    "gl": "GE",
    "lang": "ქართული",
    "hl": "ka",
    "dir": "ltr",
    "url": "https://www.google.ge/search"
  },
  {
    "name": "Georgia",
    "gl": "GE",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.ge/search"
  },
  {
    "name": "Ghana",
    "gl": "GH",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.gh/search"
  },
  {
    "name": "Ghana",
    "gl": "GH",
    "lang": "Hausa",
    "hl": "ha",
    "dir": "ltr",
    "url": "https://www.google.com.gh/search"
  },
  {
    "name": "Ghana",
    "gl": "GH",
    "lang": "Akan",
    "hl": "ak",
    "dir": "ltr",
    "url": "https://www.google.com.gh/search"
  },
  {
    "name": "Ghana",
    "gl": "GH",
    "lang": "Ewe",
    "hl": "ee",
    "dir": "ltr",
    "url": "https://www.google.com.gh/search"
  },
  {
    "name": "Ghana",
    "gl": "GH",
    "lang": "Ga",
    "hl": "gaa",
    "dir": "ltr",
    "url": "https://www.google.com.gh/search"
  },
  {
    "name": "Greece",
    "gl": "GR",
    "lang": "Ελληνικά",
    "hl": "el",
    "dir": "ltr",
    "url": "https://www.google.gr/search"
  },
  {
    "name": "Guadeloupe",
    "gl": "GP",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.gp/search"
  },
  {
    "name": "Guatemala",
    "gl": "GT",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.com.gt/search"
  },
  {
    "name": "Guyana",
    "gl": "GY",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.gy/search"
  },
  {
    "name": "Haiti",
    "gl": "HT",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.ht/search"
  },
  {
    "name": "Haiti",
    "gl": "HT",
    "lang": "Kreyòl Ayisyen",
    "hl": "ht",
    "dir": "ltr",
    "url": "https://www.google.ht/search"
  },
  {
    "name": "Haiti",
    "gl": "HT",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.ht/search"
  },
  {
    "name": "Honduras",
    "gl": "HN",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.hn/search"
  },
  {
    "name": "Hong Kong",
    "gl": "HK",
    "lang": "中文（繁體）",
    "hl": "zh-TW",
    "dir": "ltr",
    "url": "https://www.google.hk/search"
  },
  {
    "name": "Hong Kong",
    "gl": "HK",
    "lang": "中文(简体)",
    "hl": "zh-CN",
    "dir": "ltr",
    "url": "https://www.google.hk/search"
  },
  {
    "name": "Hong Kong",
    "gl": "HK",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.hk/search"
  },
  {
    "name": "Iceland",
    "gl": "IS",
    "lang": "íslenska",
    "hl": "is",
    "dir": "ltr",
    "url": "https://www.google.is/search"
  },
  {
    "name": "Iceland",
    "gl": "IS",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.is/search"
  },
  {
    "name": "India",
    "gl": "IN",
    "lang": "हिन्दी",
    "hl": "hi",
    "dir": "ltr",
    "url": "https://www.google.co.in/search"
  },
  {
    "name": "India",
    "gl": "IN",
    "lang": "বাংলা",
    "hl": "bn",
    "dir": "ltr",
    "url": "https://www.google.co.in/search"
  },
  {
    "name": "India",
    "gl": "IN",
    "lang": "తెలుగు",
    "hl": "te",
    "dir": "ltr",
    "url": "https://www.google.co.in/search"
  },
  {
    "name": "India",
    "gl": "IN",
    "lang": "मराठी",
    "hl": "mr",
    "dir": "ltr",
    "url": "https://www.google.co.in/search"
  },
  {
    "name": "India",
    "gl": "IN",
    "lang": "தமிழ்",
    "hl": "ta",
    "dir": "ltr",
    "url": "https://www.google.co.in/search"
  },
  {
    "name": "India",
    "gl": "IN",
    "lang": "ગુજરાતી",
    "hl": "gu",
    "dir": "ltr",
    "url": "https://www.google.co.in/search"
  },
  {
    "name": "India",
    "gl": "IN",
    "lang": "ಕನ್ನಡ",
    "hl": "kn",
    "dir": "ltr",
    "url": "https://www.google.co.in/search"
  },
  {
    "name": "India",
    "gl": "IN",
    "lang": "മലയാളം",
    "hl": "ml",
    "dir": "ltr",
    "url": "https://www.google.co.in/search"
  },
  {
    "name": "India",
    "gl": "IN",
    "lang": "ਪੰਜਾਬੀ",
    "hl": "pa",
    "dir": "ltr",
    "url": "https://www.google.co.in/search"
  },
  {
    "name": "Iraq",
    "gl": "IQ",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.iq/search"
  },
  {
    "name": "Iraq",
    "gl": "IQ",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.iq/search"
  },
  {
    "name": "Iraq",
    "gl": "IQ",
    "lang": "کوردی",
    "hl": "ckb",
    "dir": "rtl",
    "url": "https://www.google.iq/search"
  },
  {
    "name": "Ireland",
    "gl": "IE",
    "lang": "Gaeilge",
    "hl": "ga",
    "dir": "ltr",
    "url": "https://www.google.ie/search"
  },
  {
    "name": "Isle of Man",
    "gl": "IM",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.im/search"
  },
  {
    "name": "Israel",
    "gl": "IL",
    "lang": "עברית",
    "hl": "iw",
    "dir": "rtl",
    "url": "https://www.google.co.il/search"
  },
  {
    "name": "Israel",
    "gl": "IL",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.co.il/search"
  },
  {
    "name": "Israel",
    "gl": "IL",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.il/search"
  },
  {
    "name": "Jamaica",
    "gl": "JM",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.jm/search"
  },
  {
    "name": "Japan",
    "gl": "JP",
    "lang": "日本語",
    "hl": "ja",
    "dir": "ltr",
    "url": "https://www.google.jp/search"
  },
  {
    "name": "Jersey",
    "gl": "JE",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.je/search"
  },
  {
    "name": "Jersey",
    "gl": "JE",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.je/search"
  },
  {
    "name": "Jordan",
    "gl": "JO",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.jo/search"
  },
  {
    "name": "Jordan",
    "gl": "JO",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.jo/search"
  },
  {
    "name": "Kenya",
    "gl": "KE",
    "lang": "Kiswahili",
    "hl": "sw",
    "dir": "ltr",
    "url": "https://www.google.co.ke/search"
  },
  {
    "name": "Kenya",
    "gl": "KE",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.ke/search"
  },
  {
    "name": "Kiribati",
    "gl": "KI",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.ki/search"
  },
  {
    "name": "Kuwait",
    "gl": "KW",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.com.kw/search"
  },
  {
    "name": "Kuwait",
    "gl": "KW",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.kw/search"
  },
  {
    "name": "Kyrgyzstan",
    "gl": "KG",
    "lang": "кыргызча",
    "hl": "ky",
    "dir": "ltr",
    "url": "https://www.google.kg/search"
  },
  {
    "name": "Kyrgyzstan",
    "gl": "KG",
    "lang": "русский",
    "hl": "ru",
    "dir": "ltr",
    "url": "https://www.google.kg/search"
  },
  {
    "name": "Laos",
    "gl": "LA",
    "lang": "ລາວ",
    "hl": "lo",
    "dir": "ltr",
    "url": "https://www.google.la/search"
  },
  {
    "name": "Laos",
    "gl": "LA",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.la/search"
  },
  {
    "name": "Latvia",
    "gl": "LV",
    "lang": "latviešu",
    "hl": "lv",
    "dir": "ltr",
    "url": "https://www.google.lv/search"
  },
  {
    "name": "Latvia",
    "gl": "LV",
    "lang": "lietuvių",
    "hl": "lt",
    "dir": "ltr",
    "url": "https://www.google.lv/search"
  },
  {
    "name": "Latvia",
    "gl": "LV",
    "lang": "русский",
    "hl": "ru",
    "dir": "ltr",
    "url": "https://www.google.lv/search"
  },
  {
    "name": "Lebanon",
    "gl": "LB",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.com.lb/search"
  },
  {
    "name": "Lebanon",
    "gl": "LB",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.lb/search"
  },
  {
    "name": "Lebanon",
    "gl": "LB",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.com.lb/search"
  },
  {
    "name": "Lebanon",
    "gl": "LB",
    "lang": "հայերեն",
    "hl": "hy",
    "dir": "ltr",
    "url": "https://www.google.com.lb/search"
  },
  {
    "name": "Lesotho",
    "gl": "LS",
    "lang": "Sesotho",
    "hl": "st",
    "dir": "ltr",
    "url": "https://www.google.co.ls/search"
  },
  {
    "name": "Lesotho",
    "gl": "LS",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.ls/search"
  },
  {
    "name": "Liechtenstein",
    "gl": "LI",
    "lang": "Deutsch",
    "hl": "de",
    "dir": "ltr",
    "url": "https://www.google.li/search"
  },
  {
    "name": "Lithuania",
    "gl": "LT",
    "lang": "lietuvių",
    "hl": "lt",
    "dir": "ltr",
    "url": "https://www.google.lt/search"
  },
  {
    "name": "Luxembourg",
    "gl": "LU",
    "lang": "Deutsch",
    "hl": "de",
    "dir": "ltr",
    "url": "https://www.google.lu/search"
  },
  {
    "name": "Luxembourg",
    "gl": "LU",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.lu/search"
  },
  {
    "name": "Macedonia (FYROM)",
    "gl": "MK",
    "lang": "македонски",
    "hl": "mk",
    "dir": "ltr",
    "url": "https://www.google.mk/search"
  },
  {
    "name": "Madagascar",
    "gl": "MG",
    "lang": "Malagasy",
    "hl": "mg",
    "dir": "ltr",
    "url": "https://www.google.mg/search"
  },
  {
    "name": "Madagascar",
    "gl": "MG",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.mg/search"
  },
  {
    "name": "Malawi",
    "gl": "MW",
    "lang": "Chichewa",
    "hl": "ny",
    "dir": "ltr",
    "url": "https://www.google.mw/search"
  },
  {
    "name": "Malawi",
    "gl": "MW",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.mw/search"
  },
  {
    "name": "Malawi",
    "gl": "MW",
    "lang": "Tumbuka",
    "hl": "tum",
    "dir": "ltr",
    "url": "https://www.google.mw/search"
  },
  {
    "name": "Malaysia",
    "gl": "MY",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.my/search"
  },
  {
    "name": "Malaysia",
    "gl": "MY",
    "lang": "Melayu",
    "hl": "ms",
    "dir": "ltr",
    "url": "https://www.google.com.my/search"
  },
  {
    "name": "Maldives",
    "gl": "MV",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.mv/search"
  },
  {
    "name": "Mali",
    "gl": "ML",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.ml/search"
  },
  {
    "name": "Mexico",
    "gl": "MX",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.com.mx/search"
  },
  {
    "name": "Micronesia",
    "gl": "FM",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.fm/search"
  },
  {
    "name": "Moldova",
    "gl": "MD",
    "lang": "Română",
    "hl": "ro",
    "dir": "ltr",
    "url": "https://www.google.md/search"
  },
  {
    "name": "Moldova",
    "gl": "MD",
    "lang": "русский",
    "hl": "ru",
    "dir": "ltr",
    "url": "https://www.google.md/search"
  },
  {
    "name": "Mongolia",
    "gl": "MN",
    "lang": "Монгол",
    "hl": "mn",
    "dir": "ltr",
    "url": "https://www.google.mn/search"
  },
  {
    "name": "Montenegro",
    "gl": "ME",
    "lang": "crnogorski",
    "hl": "sr-ME",
    "dir": "ltr",
    "url": "https://www.google.me/search"
  },
  {
    "name": "Montenegro",
    "gl": "ME",
    "lang": "српски",
    "hl": "sr",
    "dir": "ltr",
    "url": "https://www.google.me/search"
  },
  {
    "name": "Montenegro",
    "gl": "ME",
    "lang": "bosanski",
    "hl": "bs",
    "dir": "ltr",
    "url": "https://www.google.me/search"
  },
  {
    "name": "Morocco",
    "gl": "MA",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.co.ma/search"
  },
  {
    "name": "Morocco",
    "gl": "MA",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.co.ma/search"
  },
  {
    "name": "Namibia",
    "gl": "NA",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.na/search"
  },
  {
    "name": "Namibia",
    "gl": "NA",
    "lang": "Afrikaans",
    "hl": "af",
    "dir": "ltr",
    "url": "https://www.google.com.na/search"
  },
  {
    "name": "Namibia",
    "gl": "NA",
    "lang": "Deutsch",
    "hl": "de",
    "dir": "ltr",
    "url": "https://www.google.com.na/search"
  },
  {
    "name": "Nauru",
    "gl": "NR",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.nr/search"
  },
  {
    "name": "Nicaragua",
    "gl": "NI",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.com.ni/search"
  },
  {
    "name": "Nicaragua",
    "gl": "NI",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.ni/search"
  },
  {
    "name": "Niger",
    "gl": "NE",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.ne/search"
  },
  {
    "name": "Niger",
    "gl": "NE",
    "lang": "Hausa",
    "hl": "ha",
    "dir": "ltr",
    "url": "https://www.google.ne/search"
  },
  {
    "name": "Nigeria",
    "gl": "NG",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.ng/search"
  },
  {
    "name": "Nigeria",
    "gl": "NG",
    "lang": "Hausa",
    "hl": "ha",
    "dir": "ltr",
    "url": "https://www.google.com.ng/search"
  },
  {
    "name": "Nigeria",
    "gl": "NG",
    "lang": "Igbo",
    "hl": "ig",
    "dir": "ltr",
    "url": "https://www.google.com.ng/search"
  },
  {
    "name": "Nigeria",
    "gl": "NG",
    "lang": "Èdè Yorùbá",
    "hl": "yo",
    "dir": "ltr",
    "url": "https://www.google.com.ng/search"
  },
  {
    "name": "Nigeria",
    "gl": "NG",
    "lang": "Nigerian Pidgin",
    "hl": "pcm",
    "dir": "ltr",
    "url": "https://www.google.com.ng/search"
  },
  {
    "name": "Niue",
    "gl": "NU",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.nu/search"
  },
  {
    "name": "Norfolk Island",
    "gl": "NF",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.nf/search"
  },
  {
    "name": "Norway",
    "gl": "NO",
    "lang": "norsk",
    "hl": "no",
    "dir": "ltr",
    "url": "https://www.google.no/search"
  },
  {
    "name": "Oman",
    "gl": "OM",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.com.om/search"
  },
  {
    "name": "Oman",
    "gl": "OM",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.om/search"
  },
  {
    "name": "Pakistan",
    "gl": "PK",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.pk/search"
  },
  {
    "name": "Pakistan",
    "gl": "PK",
    "lang": "اردو",
    "hl": "ur",
    "dir": "rtl",
    "url": "https://www.google.com.pk/search"
  },
  {
    "name": "Pakistan",
    "gl": "PK",
    "lang": "پښتو",
    "hl": "ps",
    "dir": "rtl",
    "url": "https://www.google.com.pk/search"
  },
  {
    "name": "Pakistan",
    "gl": "PK",
    "lang": "سنڌي",
    "hl": "sd",
    "dir": "rtl",
    "url": "https://www.google.com.pk/search"
  },
  {
    "name": "Palestine",
    "gl": "PS",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.ps/search"
  },
  {
    "name": "Palestine",
    "gl": "PS",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.ps/search"
  },
  {
    "name": "Panama",
    "gl": "PA",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.com.pa/search"
  },
  {
    "name": "Panama",
    "gl": "PA",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.pa/search"
  },
  {
    "name": "Papua New Guinea",
    "gl": "PG",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.pg/search"
  },
  {
    "name": "Paraguay",
    "gl": "PY",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.com.py/search"
  },
  {
    "name": "Peru",
    "gl": "PE",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.com.pe/search"
  },
  {
    "name": "Peru",
    "gl": "PE",
    "lang": "Quechua",
    "hl": "qu",
    "dir": "ltr",
    "url": "https://www.google.com.pe/search"
  },
  {
    "name": "Philippines",
    "gl": "PH",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.ph/search"
  },
  {
    "name": "Philippines",
    "gl": "PH",
    "lang": "",
    "hl": "fil",
    "dir": "ltr",
    "url": "https://www.google.ph/search"
  },
  {
    "name": "Philippines",
    "gl": "PH",
    "lang": "Cebuano",
    "hl": "ceb",
    "dir": "ltr",
    "url": "https://www.google.ph/search"
  },
  {
    "name": "Pitcairn Islands",
    "gl": "PN",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.pn/search"
  },
  {
    "name": "Portugal",
    "gl": "PT",
    "lang": "Português (Portugal)",
    "hl": "pt-PT",
    "dir": "ltr",
    "url": "https://www.google.pt/search"
  },
  {
    "name": "Puerto Rico",
    "gl": "PR",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.com.pr/search"
  },
  {
    "name": "Puerto Rico",
    "gl": "PR",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.pr/search"
  },
  {
    "name": "Qatar",
    "gl": "QA",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.com.qa/search"
  },
  {
    "name": "Qatar",
    "gl": "QA",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.qa/search"
  },
  {
    "name": "Romania",
    "gl": "RO",
    "lang": "Română",
    "hl": "ro",
    "dir": "ltr",
    "url": "https://www.google.ro/search"
  },
  {
    "name": "Romania",
    "gl": "RO",
    "lang": "magyar",
    "hl": "hu",
    "dir": "ltr",
    "url": "https://www.google.ro/search"
  },
  {
    "name": "Romania",
    "gl": "RO",
    "lang": "Deutsch",
    "hl": "de",
    "dir": "ltr",
    "url": "https://www.google.ro/search"
  },
  {
    "name": "Russia",
    "gl": "RU",
    "lang": "русский",
    "hl": "ru",
    "dir": "ltr",
    "url": "https://www.google.ru/search"
  },
  {
    "name": "Rwanda",
    "gl": "RW",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.rw/search"
  },
  {
    "name": "Rwanda",
    "gl": "RW",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.rw/search"
  },
  {
    "name": "Rwanda",
    "gl": "RW",
    "lang": "Kiswahili",
    "hl": "sw",
    "dir": "ltr",
    "url": "https://www.google.rw/search"
  },
  {
    "name": "Rwanda",
    "gl": "RW",
    "lang": "Ikinyarwanda",
    "hl": "rw",
    "dir": "ltr",
    "url": "https://www.google.rw/search"
  },
  {
    "name": "San Marino",
    "gl": "SM",
    "lang": "Italiano",
    "hl": "it",
    "dir": "ltr",
    "url": "https://www.google.sm/search"
  },
  {
    "name": "Saudi Arabia",
    "gl": "SA",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.com.sa/search"
  },
  {
    "name": "Saudi Arabia",
    "gl": "SA",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.sa/search"
  },
  {
    "name": "Serbia",
    "gl": "RS",
    "lang": "српски",
    "hl": "sr",
    "dir": "ltr",
    "url": "https://www.google.rs/search"
  },
  {
    "name": "Serbia",
    "gl": "RS",
    "lang": "srpski",
    "hl": "sr-Latn",
    "dir": "ltr",
    "url": "https://www.google.rs/search"
  },
  {
    "name": "Seychelles",
    "gl": "SC",
    "lang": "Kreol Seselwa",
    "hl": "crs",
    "dir": "ltr",
    "url": "https://www.google.sc/search"
  },
  {
    "name": "Seychelles",
    "gl": "SC",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.sc/search"
  },
  {
    "name": "Seychelles",
    "gl": "SC",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.sc/search"
  },
  {
    "name": "Sierra Leone",
    "gl": "SL",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.sl/search"
  },
  {
    "name": "Sierra Leone",
    "gl": "SL",
    "lang": "Krio (Sierra Leone)",
    "hl": "kri",
    "dir": "ltr",
    "url": "https://www.google.com.sl/search"
  },
  {
    "name": "Singapore",
    "gl": "SG",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.sg/search"
  },
  {
    "name": "Singapore",
    "gl": "SG",
    "lang": "中文(简体)",
    "hl": "zh-CN",
    "dir": "ltr",
    "url": "https://www.google.com.sg/search"
  },
  {
    "name": "Singapore",
    "gl": "SG",
    "lang": "Melayu",
    "hl": "ms",
    "dir": "ltr",
    "url": "https://www.google.com.sg/search"
  },
  {
    "name": "Singapore",
    "gl": "SG",
    "lang": "தமிழ்",
    "hl": "ta",
    "dir": "ltr",
    "url": "https://www.google.com.sg/search"
  },
  {
    "name": "Slovenia",
    "gl": "SI",
    "lang": "slovenščina",
    "hl": "sl",
    "dir": "ltr",
    "url": "https://www.google.si/search"
  },
  {
    "name": "Solomon Islands",
    "gl": "SB",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.sb/search"
  },
  {
    "name": "Somalia",
    "gl": "SO",
    "lang": "Soomaali",
    "hl": "so",
    "dir": "ltr",
    "url": "https://www.google.so/search"
  },
  {
    "name": "Somalia",
    "gl": "SO",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.so/search"
  },
  {
    "name": "Somalia",
    "gl": "SO",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.so/search"
  },
  {
    "name": "South Africa",
    "gl": "ZA",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.za/search"
  },
  {
    "name": "South Africa",
    "gl": "ZA",
    "lang": "Afrikaans",
    "hl": "af",
    "dir": "ltr",
    "url": "https://www.google.co.za/search"
  },
  {
    "name": "South Africa",
    "gl": "ZA",
    "lang": "Sesotho",
    "hl": "st",
    "dir": "ltr",
    "url": "https://www.google.co.za/search"
  },
  {
    "name": "South Africa",
    "gl": "ZA",
    "lang": "isiZulu",
    "hl": "zu",
    "dir": "ltr",
    "url": "https://www.google.co.za/search"
  },
  {
    "name": "South Africa",
    "gl": "ZA",
    "lang": "IsiXhosa",
    "hl": "xh",
    "dir": "ltr",
    "url": "https://www.google.co.za/search"
  },
  {
    "name": "South Africa",
    "gl": "ZA",
    "lang": "Setswana",
    "hl": "tn",
    "dir": "ltr",
    "url": "https://www.google.co.za/search"
  },
  {
    "name": "South Africa",
    "gl": "ZA",
    "lang": "Northern Sotho",
    "hl": "nso",
    "dir": "ltr",
    "url": "https://www.google.co.za/search"
  },
  {
    "name": "South Korea",
    "gl": "KR",
    "lang": "한국어",
    "hl": "ko",
    "dir": "ltr",
    "url": "https://www.google.co.kr/search"
  },
  {
    "name": "Spain",
    "gl": "ES",
    "lang": "català",
    "hl": "ca",
    "dir": "ltr",
    "url": "https://www.google.es/search"
  },
  {
    "name": "Spain",
    "gl": "ES",
    "lang": "galego",
    "hl": "gl",
    "dir": "ltr",
    "url": "https://www.google.es/search"
  },
  {
    "name": "Spain",
    "gl": "ES",
    "lang": "euskara",
    "hl": "eu",
    "dir": "ltr",
    "url": "https://www.google.es/search"
  },
  {
    "name": "St. Helena",
    "gl": "SH",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.sh/search"
  },
  {
    "name": "Suriname",
    "gl": "SR",
    "lang": "Nederlands",
    "hl": "nl",
    "dir": "ltr",
    "url": "https://www.google.sr/search"
  },
  {
    "name": "Suriname",
    "gl": "SR",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.sr/search"
  },
  {
    "name": "Sweden",
    "gl": "SE",
    "lang": "svenska",
    "hl": "sv",
    "dir": "ltr",
    "url": "https://www.google.se/search"
  },
  {
    "name": "Switzerland",
    "gl": "CH",
    "lang": "Deutsch",
    "hl": "de",
    "dir": "ltr",
    "url": "https://www.google.ch/search"
  },
  {
    "name": "Switzerland",
    "gl": "CH",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.ch/search"
  },
  {
    "name": "Switzerland",
    "gl": "CH",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.ch/search"
  },
  {
    "name": "Switzerland",
    "gl": "CH",
    "lang": "Italiano",
    "hl": "it",
    "dir": "ltr",
    "url": "https://www.google.ch/search"
  },
  {
    "name": "Switzerland",
    "gl": "CH",
    "lang": "Rumantsch",
    "hl": "rm",
    "dir": "ltr",
    "url": "https://www.google.ch/search"
  },
  {
    "name": "Taiwan",
    "gl": "TW",
    "lang": "中文（繁體）",
    "hl": "zh-TW",
    "dir": "ltr",
    "url": "https://www.google.com.tw/search"
  },
  {
    "name": "Tanzania",
    "gl": "TZ",
    "lang": "Kiswahili",
    "hl": "sw",
    "dir": "ltr",
    "url": "https://www.google.co.tz/search"
  },
  {
    "name": "Tanzania",
    "gl": "TZ",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.tz/search"
  },
  {
    "name": "Timor-Leste",
    "gl": "TL",
    "lang": "Português (Portugal)",
    "hl": "pt-PT",
    "dir": "ltr",
    "url": "https://www.google.tl/search"
  },
  {
    "name": "Timor-Leste",
    "gl": "TL",
    "lang": "Indonesia",
    "hl": "id",
    "dir": "ltr",
    "url": "https://www.google.tl/search"
  },
  {
    "name": "Timor-Leste",
    "gl": "TL",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.tl/search"
  },
  {
    "name": "Togo",
    "gl": "TG",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.tg/search"
  },
  {
    "name": "Togo",
    "gl": "TG",
    "lang": "Ewe",
    "hl": "ee",
    "dir": "ltr",
    "url": "https://www.google.tg/search"
  },
  {
    "name": "Tokelau",
    "gl": "TK",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.tk/search"
  },
  {
    "name": "Tonga",
    "gl": "TO",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.to/search"
  },
  {
    "name": "Tonga",
    "gl": "TO",
    "lang": "Faka-Tonga",
    "hl": "to",
    "dir": "ltr",
    "url": "https://www.google.to/search"
  },
  {
    "name": "Trinidad & Tobago",
    "gl": "TT",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.tt/search"
  },
  {
    "name": "Trinidad & Tobago",
    "gl": "TT",
    "lang": "हिन्दी",
    "hl": "hi",
    "dir": "ltr",
    "url": "https://www.google.tt/search"
  },
  {
    "name": "Trinidad & Tobago",
    "gl": "TT",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.tt/search"
  },
  {
    "name": "Trinidad & Tobago",
    "gl": "TT",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.tt/search"
  },
  {
    "name": "Trinidad & Tobago",
    "gl": "TT",
    "lang": "中文（繁體）",
    "hl": "zh-TW",
    "dir": "ltr",
    "url": "https://www.google.tt/search"
  },
  {
    "name": "Tunisia",
    "gl": "TN",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.tn/search"
  },
  {
    "name": "Tunisia",
    "gl": "TN",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.tn/search"
  },
  {
    "name": "Turkey",
    "gl": "TR",
    "lang": "Türkçe",
    "hl": "tr",
    "dir": "ltr",
    "url": "https://www.google.com.tr/search"
  },
  {
    "name": "U.S. Virgin Islands",
    "gl": "VI",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.vi/search"
  },
  {
    "name": "Uganda",
    "gl": "UG",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.ug/search"
  },
  {
    "name": "Uganda",
    "gl": "UG",
    "lang": "Luganda",
    "hl": "lg",
    "dir": "ltr",
    "url": "https://www.google.co.ug/search"
  },
  {
    "name": "Uganda",
    "gl": "UG",
    "lang": "Kiswahili",
    "hl": "sw",
    "dir": "ltr",
    "url": "https://www.google.co.ug/search"
  },
  {
    "name": "Uganda",
    "gl": "UG",
    "lang": "Ikinyarwanda",
    "hl": "rw",
    "dir": "ltr",
    "url": "https://www.google.co.ug/search"
  },
  {
    "name": "Uganda",
    "gl": "UG",
    "lang": "Luo",
    "hl": "ach",
    "dir": "ltr",
    "url": "https://www.google.co.ug/search"
  },
  {
    "name": "Uganda",
    "gl": "UG",
    "lang": "Runyakitara",
    "hl": "nyn",
    "dir": "ltr",
    "url": "https://www.google.co.ug/search"
  },
  {
    "name": "Ukraine",
    "gl": "UA",
    "lang": "українська",
    "hl": "uk",
    "dir": "ltr",
    "url": "https://www.google.com.ua/search"
  },
  {
    "name": "Ukraine",
    "gl": "UA",
    "lang": "русский",
    "hl": "ru",
    "dir": "ltr",
    "url": "https://www.google.com.ua/search"
  },
  {
    "name": "United Arab Emirates",
    "gl": "AE",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.ae/search"
  },
  {
    "name": "United Arab Emirates",
    "gl": "AE",
    "lang": "فارسی",
    "hl": "fa",
    "dir": "rtl",
    "url": "https://www.google.ae/search"
  },
  {
    "name": "United Arab Emirates",
    "gl": "AE",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.ae/search"
  },
  {
    "name": "United Arab Emirates",
    "gl": "AE",
    "lang": "हिन्दी",
    "hl": "hi",
    "dir": "ltr",
    "url": "https://www.google.ae/search"
  },
  {
    "name": "United Arab Emirates",
    "gl": "AE",
    "lang": "اردو",
    "hl": "ur",
    "dir": "rtl",
    "url": "https://www.google.ae/search"
  },
  {
    "name": "Uruguay",
    "gl": "UY",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.com.uy/search"
  },
  {
    "name": "Uzbekistan",
    "gl": "UZ",
    "lang": "O‘zbek",
    "hl": "uz",
    "dir": "ltr",
    "url": "https://www.google.co.uz/search"
  },
  {
    "name": "Uzbekistan",
    "gl": "UZ",
    "lang": "русский",
    "hl": "ru",
    "dir": "ltr",
    "url": "https://www.google.co.uz/search"
  },
  {
    "name": "Vanuatu",
    "gl": "VU",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.vu/search"
  },
  {
    "name": "Vanuatu",
    "gl": "VU",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.vu/search"
  },
  {
    "name": "Venezuela",
    "gl": "VE",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.co.ve/search"
  },
  {
    "name": "Vietnam",
    "gl": "VN",
    "lang": "Tiếng Việt",
    "hl": "vi",
    "dir": "ltr",
    "url": "https://www.google.vn/search"
  },
  {
    "name": "Vietnam",
    "gl": "VN",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.vn/search"
  },
  {
    "name": "Vietnam",
    "gl": "VN",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.vn/search"
  },
  {
    "name": "Vietnam",
    "gl": "VN",
    "lang": "中文（繁體）",
    "hl": "zh-TW",
    "dir": "ltr",
    "url": "https://www.google.vn/search"
  },
  {
    "name": "Zambia",
    "gl": "ZM",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.zm/search"
  },
  {
    "name": "Zambia",
    "gl": "ZM",
    "lang": "Chichewa",
    "hl": "ny",
    "dir": "ltr",
    "url": "https://www.google.co.zm/search"
  },
  {
    "name": "Zambia",
    "gl": "ZM",
    "lang": "IciBemba",
    "hl": "bem",
    "dir": "ltr",
    "url": "https://www.google.co.zm/search"
  },
  {
    "name": "Zambia",
    "gl": "ZM",
    "lang": "Tumbuka",
    "hl": "tum",
    "dir": "ltr",
    "url": "https://www.google.co.zm/search"
  },
  {
    "name": "Zambia",
    "gl": "ZM",
    "lang": "Lozi",
    "hl": "loz",
    "dir": "ltr",
    "url": "https://www.google.co.zm/search"
  },
  {
    "name": "Zimbabwe",
    "gl": "ZW",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.zw/search"
  },
  {
    "name": "Zimbabwe",
    "gl": "ZW",
    "lang": "ChiShona",
    "hl": "sn",
    "dir": "ltr",
    "url": "https://www.google.co.zw/search"
  },
  {
    "name": "Zimbabwe",
    "gl": "ZW",
    "lang": "isiZulu",
    "hl": "zu",
    "dir": "ltr",
    "url": "https://www.google.co.zw/search"
  },
  {
    "name": "Zimbabwe",
    "gl": "ZW",
    "lang": "Chichewa",
    "hl": "ny",
    "dir": "ltr",
    "url": "https://www.google.co.zw/search"
  },
  {
    "name": "Zimbabwe",
    "gl": "ZW",
    "lang": "Setswana",
    "hl": "tn",
    "dir": "ltr",
    "url": "https://www.google.co.zw/search"
  },
  {
    "name": "Andorra",
    "gl": "AD",
    "lang": "català",
    "hl": "ca",
    "dir": "ltr",
    "url": "https://www.google.ad/search"
  },
  {
    "name": "Belize",
    "gl": "BZ",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.bz/search"
  },
  {
    "name": "Belize",
    "gl": "BZ",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.com.bz/search"
  },
  {
    "name": "Bhutan",
    "gl": "BT",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.bt/search"
  },
  {
    "name": "Central African Republic",
    "gl": "CF",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.cf/search"
  },
  {
    "name": "Côte d’Ivoire",
    "gl": "CI",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.ci/search"
  },
  {
    "name": "Cuba",
    "gl": "CU",
    "lang": "Español (Latinoamérica)",
    "hl": "es-419",
    "dir": "ltr",
    "url": "https://www.google.com.cu/search"
  },
  {
    "name": "Ethiopia",
    "gl": "ET",
    "lang": "አማርኛ",
    "hl": "am",
    "dir": "ltr",
    "url": "https://www.google.com.et/search"
  },
  {
    "name": "Ethiopia",
    "gl": "ET",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.et/search"
  },
  {
    "name": "Ethiopia",
    "gl": "ET",
    "lang": "ትግርኛ",
    "hl": "ti",
    "dir": "ltr",
    "url": "https://www.google.com.et/search"
  },
  {
    "name": "Ethiopia",
    "gl": "ET",
    "lang": "Soomaali",
    "hl": "so",
    "dir": "ltr",
    "url": "https://www.google.com.et/search"
  },
  {
    "name": "Ethiopia",
    "gl": "ET",
    "lang": "Afaan Oromoo",
    "hl": "om",
    "dir": "ltr",
    "url": "https://www.google.com.et/search"
  },
  {
    "name": "Greenland",
    "gl": "GL",
    "lang": "Dansk",
    "hl": "da",
    "dir": "ltr",
    "url": "https://www.google.gl/search"
  },
  {
    "name": "Greenland",
    "gl": "GL",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.gl/search"
  },
  {
    "name": "Guernsey",
    "gl": "GG",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.gg/search"
  },
  {
    "name": "Guernsey",
    "gl": "GG",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.gg/search"
  },
  {
    "name": "Hungary",
    "gl": "HU",
    "lang": "magyar",
    "hl": "hu",
    "dir": "ltr",
    "url": "https://www.google.hu/search"
  },
  {
    "name": "Indonesia",
    "gl": "ID",
    "lang": "Indonesia",
    "hl": "id",
    "dir": "ltr",
    "url": "https://www.google.co.id/search"
  },
  {
    "name": "Indonesia",
    "gl": "ID",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.id/search"
  },
  {
    "name": "Indonesia",
    "gl": "ID",
    "lang": "",
    "hl": "jv",
    "dir": "ltr",
    "url": "https://www.google.co.id/search"
  },
  {
    "name": "Indonesia",
    "gl": "ID",
    "lang": "Basa Bali",
    "hl": "ban",
    "dir": "ltr",
    "url": "https://www.google.co.id/search"
  },
  {
    "name": "Italy",
    "gl": "IT",
    "lang": "Italiano",
    "hl": "it",
    "dir": "ltr",
    "url": "https://www.google.it/search"
  },
  {
    "name": "Kazakhstan",
    "gl": "KZ",
    "lang": "қазақ",
    "hl": "kk",
    "dir": "ltr",
    "url": "https://www.google.kz/search"
  },
  {
    "name": "Kazakhstan",
    "gl": "KZ",
    "lang": "русский",
    "hl": "ru",
    "dir": "ltr",
    "url": "https://www.google.kz/search"
  },
  {
    "name": "Malta",
    "gl": "MT",
    "lang": "Malti",
    "hl": "mt",
    "dir": "ltr",
    "url": "https://www.google.com.mt/search"
  },
  {
    "name": "Malta",
    "gl": "MT",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.mt/search"
  },
  {
    "name": "Mauritius",
    "gl": "MU",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.mu/search"
  },
  {
    "name": "Mauritius",
    "gl": "MU",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.mu/search"
  },
  {
    "name": "Mauritius",
    "gl": "MU",
    "lang": "Kreol morisien",
    "hl": "mfe",
    "dir": "ltr",
    "url": "https://www.google.mu/search"
  },
  {
    "name": "Montserrat",
    "gl": "MS",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.ms/search"
  },
  {
    "name": "Mozambique",
    "gl": "MZ",
    "lang": "Português (Portugal)",
    "hl": "pt-PT",
    "dir": "ltr",
    "url": "https://www.google.co.mz/search"
  },
  {
    "name": "Mozambique",
    "gl": "MZ",
    "lang": "Kiswahili",
    "hl": "sw",
    "dir": "ltr",
    "url": "https://www.google.co.mz/search"
  },
  {
    "name": "Mozambique",
    "gl": "MZ",
    "lang": "Chichewa",
    "hl": "ny",
    "dir": "ltr",
    "url": "https://www.google.co.mz/search"
  },
  {
    "name": "Mozambique",
    "gl": "MZ",
    "lang": "ChiShona",
    "hl": "sn",
    "dir": "ltr",
    "url": "https://www.google.co.mz/search"
  },
  {
    "name": "Myanmar (Burma)",
    "gl": "MM",
    "lang": "မြန်မာ (မြန်မာ)",
    "hl": "my",
    "dir": "ltr",
    "url": "https://www.google.com.mm/search"
  },
  {
    "name": "Myanmar (Burma)",
    "gl": "MM",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.mm/search"
  },
  {
    "name": "Nepal",
    "gl": "NP",
    "lang": "नेपाली",
    "hl": "ne",
    "dir": "ltr",
    "url": "https://www.google.com.np/search"
  },
  {
    "name": "Nepal",
    "gl": "NP",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.np/search"
  },
  {
    "name": "Samoa",
    "gl": "WS",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.ws/search"
  },
  {
    "name": "Senegal",
    "gl": "SN",
    "lang": "Français",
    "hl": "fr",
    "dir": "ltr",
    "url": "https://www.google.sn/search"
  },
  {
    "name": "Senegal",
    "gl": "SN",
    "lang": "Wolof",
    "hl": "wo",
    "dir": "ltr",
    "url": "https://www.google.sn/search"
  },
  {
    "name": "Slovakia",
    "gl": "SK",
    "lang": "slovenčina",
    "hl": "sk",
    "dir": "ltr",
    "url": "https://www.google.sk/search"
  },
  {
    "name": "St. Vincent & Grenadines",
    "gl": "VC",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.vc/search"
  },
  {
    "name": "Tajikistan",
    "gl": "TJ",
    "lang": "Тоҷикӣ",
    "hl": "tg",
    "dir": "ltr",
    "url": "https://www.google.com.tj/search"
  },
  {
    "name": "Tajikistan",
    "gl": "TJ",
    "lang": "русский",
    "hl": "ru",
    "dir": "ltr",
    "url": "https://www.google.com.tj/search"
  },
  {
    "name": "Thailand",
    "gl": "TH",
    "lang": "ภาษาไทย",
    "hl": "th",
    "dir": "ltr",
    "url": "https://www.google.co.th/search"
  },
  {
    "name": "Thailand",
    "gl": "TH",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.th/search"
  },
  {
    "name": "Turkmenistan",
    "gl": "TM",
    "lang": "türkmençe",
    "hl": "tk",
    "dir": "ltr",
    "url": "https://www.google.tm/search"
  },
  {
    "name": "Turkmenistan",
    "gl": "TM",
    "lang": "русский",
    "hl": "ru",
    "dir": "ltr",
    "url": "https://www.google.tm/search"
  },
  {
    "name": "Turkmenistan",
    "gl": "TM",
    "lang": "O‘zbek",
    "hl": "uz",
    "dir": "ltr",
    "url": "https://www.google.tm/search"
  },
  {
    "name": "Gibraltar",
    "gl": "GI",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.gi/search"
  },
  {
    "name": "Gibraltar",
    "gl": "GI",
    "lang": "español",
    "hl": "es",
    "dir": "ltr",
    "url": "https://www.google.com.gi/search"
  },
  {
    "name": "Gibraltar",
    "gl": "GI",
    "lang": "Italiano",
    "hl": "it",
    "dir": "ltr",
    "url": "https://www.google.com.gi/search"
  },
  {
    "name": "Gibraltar",
    "gl": "GI",
    "lang": "Português (Portugal)",
    "hl": "pt-PT",
    "dir": "ltr",
    "url": "https://www.google.com.gi/search"
  },
  {
    "name": "Libya",
    "gl": "LY",
    "lang": "العربية",
    "hl": "ar",
    "dir": "rtl",
    "url": "https://www.google.com.ly/search"
  },
  {
    "name": "Libya",
    "gl": "LY",
    "lang": "Italiano",
    "hl": "it",
    "dir": "ltr",
    "url": "https://www.google.com.ly/search"
  },
  {
    "name": "Libya",
    "gl": "LY",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.com.ly/search"
  },
  {
    "name": "Netherlands",
    "gl": "NL",
    "lang": "Frysk",
    "hl": "fy",
    "dir": "ltr",
    "url": "https://www.google.nl/search"
  },
  {
    "name": "New Zealand",
    "gl": "NZ",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.co.nz/search"
  },
  {
    "name": "New Zealand",
    "gl": "NZ",
    "lang": "Māori",
    "hl": "mi",
    "dir": "ltr",
    "url": "https://www.google.co.nz/search"
  },
  {
    "name": "Poland",
    "gl": "PL",
    "lang": "polski",
    "hl": "pl",
    "dir": "ltr",
    "url": "https://www.google.pl/search"
  },
  {
    "name": "Sri Lanka",
    "gl": "LK",
    "lang": "English",
    "hl": "en",
    "dir": "ltr",
    "url": "https://www.google.lk/search"
  },
  {
    "name": "Sri Lanka",
    "gl": "LK",
    "lang": "සිංහල",
    "hl": "si",
    "dir": "ltr",
    "url": "https://www.google.lk/search"
  },
  {
    "name": "Sri Lanka",
    "gl": "LK",
    "lang": "தமிழ்",
    "hl": "ta",
    "dir": "ltr",
    "url": "https://www.google.lk/search"
  },
  {
    "name": "São Tomé & Príncipe",
    "gl": "ST",
    "lang": "Português (Portugal)",
    "hl": "pt-PT",
    "dir": "ltr",
    "url": "https://www.google.st/search"
  }
];

function genGeoCode(latitude, longitude) {
  var lat = Math.round(1E7 * latitude);
  var lng = Math.round(1E7 * longitude);
  var now = (new Date).getTime();
  var a = 150 * 620;
  var c = String(1E3 * Number(now));
  var d = ["role:"];
  d.push(1);
  d.push("\nproducer:");
  d.push(12);
  d.push("\nprovenance:");
  d.push(6);
  d.push("\ntimestamp:");
  d.push(c);
  d.push("\nlatlng{\nlatitude_e7:");
  d.push(lat);
  d.push("\nlongitude_e7:");
  d.push(lng);
  d.push("\n}\nradius:");
  d.push(a);

  var b = d.join("");
  var uule = 'a '+window.btoa(b).replace(/\+/g, "-").replace(/\//g, "_");
  return uule;
}

function setupAdress(location) {
  if (showMap) {
    // delete old marker
    marker.setMap(null);

    map.setZoom(15);
    // set new marker
    marker = new google.maps.Marker({
      position: location,
      map: map,
      draggable: true,
      animation: google.maps.Animation.DROP
    });
    marker.addListener('dragend', markerUp);
    map.setCenter(marker.getPosition());
  }
  setSettings();
}

function fillInAddress() {
  // console.log('Address Changed');
  var newplace = autocomplete.getPlace(),
      newlat = newplace.geometry.location.lat(),
      newlng = newplace.geometry.location.lng();
  updateLatLng(newlat,newlng);
  setupAdress(newplace.geometry.location);

  // var place_id;
  // try {
  //   if (autocomplete.gm_accessors_.place.Rc) {
  //     place_id = autocomplete.gm_accessors_.place.Rc.place.place_id;
  //   } else {
  //     place_id = autocomplete.gm_accessors_.place.Wc.place.place_id;
  //   }
  //   fetch('/location?placeId='+place_id)
  //     .then(function (response) {
  //       return response.json()
  //     })
  //     .then(function (data) {
  //       updateLatLng(data.lat,data.lng);
  //       var myLocation = new google.maps.LatLng(data.lat,data.lng);
  //       setupAdress(myLocation);
  //     })
  //     .catch(function (error) {
        // console.log('Request failed', error);
  //       var place = autocomplete.getPlace();
  //       var lat = place.geometry.location.lat();
  //       var lng = place.geometry.location.lng();
  //       updateLatLng(lat, lng);
  //       try {
  //         var data = {
  //           lat: lat,
  //           lng: lng,
  //           placeId: place['place_id'],
  //           name: place['name'],
  //           place: $('#place').val()
  //         };
  //         var url = '/location'
  //         fetch(url, {
  //           method: 'POST',
  //           headers: {
  //             'Content-Type': 'application/json'
  //           },
  //           body: JSON.stringify(data)
  //         })
  //         .catch(function (error) {
  //           console.error('Error:', error);
  //         })
  //         .then(function (response) {
  //             console.log('Success:', response.text());
  //         });
  //       } catch (e) {
  //         console.log(e);
  //       }
  //       setupAdress(place.geometry.location);
  //     });
  // } catch (e) {}
}

var autocomplete;
function initAutocomplete() {
  autocomplete = new google.maps.places.Autocomplete(
      (document.getElementById('place')),
      {types: ['geocode']});

  autocomplete.setFields(['place_id', 'name', 'types', 'geometry']);
  autocomplete.addListener('place_changed', fillInAddress);

  if (showMap) {
    map.addListener('bounds_changed', function() {
      autocomplete.setBounds(map.getBounds());
    });
  }
}

function updateLatLng(lat, lng) {
  lat = Math.floor(lat*1e7)/1e7;
  lng = Math.floor(lng*1e7)/1e7;
  $('#latitude').val(lat);
  $('#longitude').val(lng);
  var geocode = genGeoCode(lat, lng);
  $('#uule').val(geocode);
  initAC();
}

var map,marker,geocoder;
function updateLocationField(lat, lng) {
  var latlng = {lat: parseFloat(lat), lng: parseFloat(lng)};
  geocoder.geocode({'location': latlng}, function(results, status) {
    if (status === 'OK') {
      if (results[0]) {
        $('#place').val(results[0].formatted_address);
        setSettings();
      }
    } else {
      console.log('Geocoder failed due to: ' + status);
    }
  });
}
function mapClick(event) {
  var lat = event.latLng.lat();
  var lng = event.latLng.lng();
  updateLatLng(lat, lng);
  updateLocationField(lat, lng)

  // delete old marker
  marker.setMap(null);

  // set new marker
  marker = new google.maps.Marker({
    position: event.latLng,
    map: map,
    draggable: true,
    animation: google.maps.Animation.DROP
  });
  marker.addListener('dragend', markerUp);
  map.setZoom(15);
  map.setCenter(marker.getPosition());
  //setSettings();
};
function markerUp(event) {
  var lat = event.latLng.lat();
  var lng = event.latLng.lng();
  updateLatLng(lat, lng);
  updateLocationField(lat, lng)
  map.setZoom(15);
  map.setCenter(marker.getPosition());
  //setSettings();
}
function initMap() {
  if (showMap) {
    var mapCenter = {
      lat: parseFloat(setting.latitude) || 37.421,
      lng: parseFloat(setting.longitude) || -122.084
    };
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      center: mapCenter,
      mapTypeId: 'roadmap',
      fullscreenControl: false,
      mapTypeControl: false,
      streetViewControl: false
    });

    marker = new google.maps.Marker({
      map: map,
      draggable: true,
      animation: google.maps.Animation.DROP,
      position: mapCenter
    });
    marker.addListener('dragend', markerUp);
    map.addListener('click', mapClick);
  }

  // Create the search box and link it to the UI element.
  var input = document.getElementById('place');
  initAutocomplete();

  geocoder = new google.maps.Geocoder;
};

function storageAvailable(type) {
  try {
    var storage = window[type],
        x = '__storage_test__';
    storage.setItem(x, x);
    storage.removeItem(x);
    return true;
  }
  catch(e) {
    return e instanceof DOMException && (
      // everything except Firefox
      e.code === 22 ||
      // Firefox
      e.code === 1014 ||
      // test name field too, because code might not be present
      // everything except Firefox
      e.name === 'QuotaExceededError' ||
      // Firefox
      e.name === 'NS_ERROR_DOM_QUOTA_REACHED') &&
      // acknowledge QuotaExceededError only if there's something already stored
      storage.length !== 0;
  }
}

function getSettings() {
  if (!storageAvailable('localStorage')) {
    initAC();
    return;
  }
  if (localStorage.getItem('keywordTracker')) {
    try {
      settings = JSON.parse(localStorage.getItem('keywordTracker'));
      if (settings.length > 0) {
        setting = settings[0];
        updateLatLng(setting['latitude'], setting['longitude']);
        $('#regions').val(setting['regions']);
        $('#place').val(setting['place']);
        $('#hl').val(setting['hl']);
        $('#gl').val(setting['gl']);
        loadAPI(setting.hl, setting.gl);
      }
    } catch (e) {}
  } else {
    if (settings.length == 0) {
      settings = [{"hl":"en","gl":"US","latitude":"37.421","longitude":"-122.084","regions":"United States – English","place":""}];
      setting = settings[0];
      updateLatLng(setting['latitude'], setting['longitude']);
      $('#regions').val(setting['regions']);
      $('#place').val(setting['place']);
      $('#hl').val(setting['hl']);
      $('#gl').val(setting['gl']);
      loadAPI(setting.hl, setting.gl);
      setSettings();
    }
  }
  initAC();
}
var acEngine;
var tempTag = document.createElement('div');
function html2text(html) {
  tempTag.innerHTML = html;
  return tempTag.textContent || tempTag.innerText || "";
}
function initEngine() {
  var hl = $('#hl').val();
  var gl = $('#gl').val();
  var uule = $('#uule').val();
  var parameters = {
    "hl": hl,
    "gl": gl,
    "xhr": 0,
    "client": 'psy-ab'
  };
  if (acEngine) {
    acEngine.clearRemoteCache();
    acEngine.clear();
  }
  acEngine = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      wildcard: '%QUERY',
      url: 'https://www.google.com/complete/search?q=%QUERY&' + jQuery.param(parameters),
      rateLimitWait: 1,
      transform: function (results) {
        return $.map(results[1], function (keyword) {
          return html2text(keyword[0]);
        });
      },
      prepare: function(query, settings) {
        settings.dataType = "jsonp";
        settings.url = settings.url.replace('%QUERY', query);
        return settings;
      }
    }
  });
  acEngine.initialize(true);
}
function setSettings() {
  if (!storageAvailable('localStorage')) {
    return;
  }
  setting = {
    hl: $('#hl').val(),
    gl: $('#gl').val(),
    latitude: $('#latitude').val(),
    longitude: $('#longitude').val(),
    regions: $('#regions').val(),
    place: $('#place').val()
  };
  //settings.splice(0, 0, setting);
  settings = [setting];
  localStorage.setItem('keywordTracker', JSON.stringify(settings));
}

var dachshound = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name','lang'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  identify: function(obj) { return obj.hl + obj.gl; },
  local: google_sites
});

function initAC() {
  try {
    $('#search-input').typeahead('destroy');
  } catch (e) {}
  initEngine();
  $('#search-input').typeahead({
    hint: true,
    highlight: true,
    minLength: 1,
    limit: 10
  },
  {
    name: 'google',
    source: acEngine
  });
}

function loadAPI(hl, gl) {
  //Destroy old API
  try {
    document.querySelectorAll('script[src^="https://maps.googleapis.com"]').forEach(function (script) {
      script.remove();
    });
    if (google) {
      delete google.maps;
    }
  } catch (e) {}

  //Load new API
  var mapsApi = document.createElement('script');
  mapsApi.src = 'https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyD7i2YsZwik9lzgxEVOlEJhQzASFBlq81w&callback=initMap&language='+hl+'&region='+gl;
  mapsApi.setAttribute('async', '');
  mapsApi.setAttribute('defer', '');
  document.head.appendChild(mapsApi);
}

$(document).ready(function() {
  // need to stop prop of the touchend event
  if (navigator.userAgent.match(/(iPad|iPhone|iPod)/g)) {
    setTimeout(function() {
      var container = document.getElementsByClassName('pac-container')[0];
      container.addEventListener('touchend', function(e) {
        e.stopImmediatePropagation();
      });
    }, 500);
  }

  $('#showMap').on( "click", function() {
    showMap = this.checked;
    
    if (showMap) {
      $('#map').addClass('map');      
      $('#map').show();
      initMap();

    } else {
      $('#map').removeClass("map");
      $('#map').hide();
    }
   
  });

  $('#regions').typeahead({
    hint: true,
    highlight: true,
    minLength: 1,
    limit: 10
  },
  {
    display: function(item){ return item.name+' – '+item.lang},
    name: 'states',
    source: dachshound,
    templates: {
      suggestion: Handlebars.compile('<p>{{name}} - <span>{{lang}}</span></p>')
    }
  });
  $('.typeahead').bind('typeahead:select', function(ev, data) {
    $('#hl').val(data.hl);
    $('#gl').val(data.gl);
    $('#search-container').attr('action', data.url);
    loadAPI(data.hl, data.gl)
    setSettings();
    initAC();
  });

  getSettings();

});
