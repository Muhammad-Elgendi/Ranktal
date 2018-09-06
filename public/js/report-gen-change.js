function change() {
    errorsCount = 0;
    passedCount = 0;
    // change state code here
    document.getElementById("url").innerHTML = response.url;
    document.getElementById("url").href = response.url;
    document.getElementById("date").innerHTML = response.created_at;

    // <!-- Title Result-->
    if (response.checkTitle !== null) {
        progress(10);
        if (response.checkTitle === true) {
            passedCount++;
            document.getElementById("title-section").innerHTML = "";
            document.getElementById("title-section").className = "";
            document.getElementById("title-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">وسم العنوان</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.checkTitle === false) {
            errorsCount++;
            document.getElementById("title-section").innerHTML = "";
            document.getElementById("title-section").className = "";
            document.getElementById("title-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">وسم العنوان</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('title-section').insertAdjacentHTML('beforeend',
            "<div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        يعد عنوان الصفحه من أهم العوامل المهمه جداً ، و يقوم جوجل بإعادة كتابة هذا العنوان في حالات قليله جداً مثلاً إذا كان العنوان لا يناسب جملة البحث ولكن الصفحة تحتوي علي شيء يخص جملة البحث\n" +
            "    </article>\n" +
            "    <div class=\"clear padding-top\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>يجب أن يحتوي العنوان علي أهم الكلمات المفتاحيه التي تستهدفها بهذه الصفحه</p>\n" +
            "    </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>يجب أن يكون لكل صفحه في موقعك عنوان فريد خاص بها</p>\n" +
            "    </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>يجب أن تحتوي الصفحه علي وسم عنوان واحد فقط</p>\n" +
            "    </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>يجب أن يكون طول العنوان مناسباً بحيث لا يقل عن 10 أحرف ولا يزيد عن 60 حرف</p>\n" +
            "    </div>\n" +
            "    </div>"
        );
        if (response.hasTitle === true) {
            document.getElementById("title-section").insertAdjacentHTML('beforeend',
                "<div class=\"clear\">\n" +
                "        <h2 class='item-name'>العنوان</h2>\n" +
                "        <p class='right-paragraph'>" + response.title + "</p>" +
                " <i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>" +
                "   </div>\n" +
                "    <div class=\"clear\">\n" +
                "        <h2 class='item-name'>طول العنوان</h2>\n" +
                "    <p class='right-paragraph'>" + response.lengthTitle + " حرف</p>"
            );
            if (response.checkLengthTitle === true) {
                document.getElementById("title-section").insertAdjacentHTML('beforeend',
                    "<i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>"
                );
            }
            else if (response.checkLengthTitle === false) {
                document.getElementById("title-section").insertAdjacentHTML('beforeend',
                    "  <i class=\"fa fa-times-circle fail-mark\" aria-hidden=\"true\"></i>"
                );
            }
            document.getElementById("title-section").insertAdjacentHTML('beforeend',
                " </div>\n" +
                " <div class=\"clear\">\n" +
                "        <h2 class='item-name'>الصفحة تحتوي علي عنوان واحد فقط</h2>"
            );
            if (!response.duplicateTitle === true) {
                document.getElementById("title-section").insertAdjacentHTML('beforeend',
                    "<i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>"
                );
            }
            else if (!response.duplicateTitle === false) {
                document.getElementById("title-section").insertAdjacentHTML('beforeend',
                    "  <i class=\"fa fa-times-circle fail-mark\" aria-hidden=\"true\"></i>"
                );
            }
            document.getElementById("title-section").insertAdjacentHTML('beforeend',
                "<div class='clear'></div> " +
                "</div>"
            );
        }
        else if (response.hasTitle === false) {
            document.getElementById("title-section").insertAdjacentHTML('beforeend',
                "  <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>خطأ</h2>\n" +
                "        <p>الصفحة لا تحتوي علي عنوان</p>\n" +
                "    </div>"
            );
        }
    }

    // Url Result
    if (response.checkUrl !== null && response.url !== null) {
        progress(20);
        if (response.checkUrl === true) {
            passedCount++;
            document.getElementById("url-section").innerHTML = "";
            document.getElementById("url-section").className = "";
            document.getElementById("url-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">الرابط</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.checkUrl === false) {
            errorsCount++;
            document.getElementById("url-section").innerHTML = "";
            document.getElementById("url-section").className = "";
            document.getElementById("url-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">الرابط</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('url-section').insertAdjacentHTML('beforeend',
            '   <div class="alert alert-info">\n' +
            '                    <i class="fa fa-info-circle" aria-hidden="true"></i>\n' +
            '                    <strong>معلومه</strong>\n' +
            '                    <article>\n' +
            '                        يعد وجود الكلمه المفتاحيه بإسم النطاق الخاص بموقعك أو رابط الصفحه عامل مهم يمثل نسبة 2% من\n' +
            '                        العوامل التي يرتب بها جوجل نتائج البحث، ويجب الفصل بين الكلمات وبعضها بشرطة "-" Dash بدلا من\n' +
            '                        المسافة العادية\n' +
            '                        <br>\n' +
            '                        مثال :\n' +
            '                        كلمة-مفتاحيه-للموضوع-أو-المقال-أو-عنوان-الموضوع/www.example.com\n' +
            '                    </article>\n' +
            '                    <div class="clear padding-top">\n' +
            '                        <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>\n' +
            '                        <p class="right-paragraph">يجب أن لا يتعدي طول الرابط 200 حرف</p>\n' +
            '                    </div>\n' +
            '                    <div class="clear">\n' +
            '                        <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>\n' +
            '                        <p class="right-paragraph">يجب أن تكون حالة الرابط 200 أو 301 أو 404 أو 503</p>\n' +
            '                    </div>\n' +
            '                    <div class="clear padding-bottom">\n' +
            '                        <i class="fa fa-check-circle-o success-mark info" aria-hidden="true"></i>\n' +
            '                        <p class="right-paragraph">يجب أن لا يحتوي الرابط علي مسافات</p>\n' +
            '                    </div>\n' +
            '                </div>'
        );
        document.getElementById('url-section').insertAdjacentHTML('beforeend',
            "<div class=\"clear\">\n" +
            "                <h2 class='item-name'>الرابط</h2>\n" +
            "                <p class=\"right-paragraph\">" + response.url + "</p>\n" +
            "                </div>"
        );
        document.getElementById('url-section').insertAdjacentHTML('beforeend',
            "<div class=\"clear\">\n" +
            "                <h2 class='item-name'>طول الرابط</h2>\n" +
            "            <p class=\"right-paragraph\">" + response.lengthUrl + " حرف</p>"
        );

        if (response.checkLengthUrl === true) {
            document.getElementById('url-section').insertAdjacentHTML('beforeend',
                "<i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>"
            );
        }
        else if (response.checkLengthUrl === false) {
            document.getElementById('url-section').insertAdjacentHTML('beforeend',
                "<i class=\"fa fa-times-circle fail-mark\" aria-hidden=\"true\"></i>"
            );
        }
        document.getElementById('url-section').insertAdjacentHTML('beforeend',
            "  </div>\n" +
            "                <div class=\"clear\">\n" +
            "                <h2 class='item-name'>حالة الرابط</h2>\n" +
            "            <p class=\"right-paragraph\">" + response.statusUrl + "</p>"
        );

        if (response.checkStatusUrl === true) {
            document.getElementById('url-section').insertAdjacentHTML('beforeend',
                "<i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>"
            );

        }
        else if (response.checkStatusUrl === false) {
            document.getElementById('url-section').insertAdjacentHTML('beforeend',
                "<i class=\"fa fa-times-circle fail-mark\" aria-hidden=\"true\"></i>"
            );
        }
        document.getElementById('url-section').insertAdjacentHTML('beforeend',
            "    </div>\n" +
            "                <div class=\"clear\">\n" +
            "                <h2 class='item-name'>عدد المسافات فى الرابط</h2>\n" +
            "            <p class=\"right-paragraph\">" + response.spacesUrl + "</p>"
        );

        if (response.checkSpacesUrl === true) {
            document.getElementById('url-section').insertAdjacentHTML('beforeend',
                "<i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>"
            );
        }
        else if (response.checkSpacesUrl === false) {
            document.getElementById('url-section').insertAdjacentHTML('beforeend',
                "<i class=\"fa fa-times-circle fail-mark\" aria-hidden=\"true\"></i>"
            );
        }
        document.getElementById('url-section').insertAdjacentHTML('beforeend',
            "    </div>\n" +
            "                <div class=\"clear\">\n" +
            "                <h2 class='item-name'>رابط الأرشفه</h2>\n" +
            "            <p><a target='_blank' href=\"" + response.googleCacheUrl + "\">" + response.googleCacheUrl + "</a></p>\n" +
            "            </div>\n" +
            "            <div class=\"clear\">\n" +
            "                <h2 class='item-name'>إسم النطاق</h2>\n" +
            "            <p>" + response.domain + "</p>\n" +
            "            </div>\n" +
            "            <div class=\"clear padding-bottom\">\n" +
            "                <h2 class='item-name'>طول إسم النطاق</h2>\n" +
            "            <p>" + response.domainLength + " حرف</p>" +
            "            </div>"
        );
    }
    var content;
    // <!-- Description Result-->
    if (response.checkDescription !== null) {
        if (response.checkDescription === true) {
            passedCount++;
            document.getElementById("description-section").innerHTML = "";
            document.getElementById("description-section").className = "";
            content = '';
            content +='<div class="success">\n' +
                '                <h1 class="item-title">وسم الوصف</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>';

        }
        else if (response.checkDescription === false) {
            errorsCount++;
            document.getElementById("description-section").innerHTML = "";
            document.getElementById("description-section").className = "";
            content = '';
            content += '<div class="fail">\n' +
               '                <h1 class="item-title">وسم الوصف</h1>\n' +
               '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
               '                </div>';
        }

        content+=    " <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        يعد وصف الصفحه بالانجليزيه Description meta tag من أهم وسوم Meta التي يجب عليك كتابتها بدقه فهي أول شيء\n" +
            "    يراه الزائر من محتوي الموقع لذا إحرص علي أن يكون جذاباً\n" +
            "    </article>\n" +
            "    <div class=\"clear padding-top\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>يجب أن يحتوي الوصف علي أهم الكلمات المفتاحيه التي تستهدفها بهذه الصفحه</p>\n" +
            "    </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>يجب أن يكون الوصف مقروءاً للزائر وجذاباً ولا يضلل الزائر</p>\n" +
            "    </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>يجب أن تحتوي الصفحه علي وصف واحد فقط</p>\n" +
            "    </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>يجب أن يكون طول الوصف مناسباً بحيث لا يقل عن 70 حرف ولا يزيد عن 160 حرف</p>\n" +
            "    </div>\n" +
            "    </div>";

        if (response.hasDescription === true) {
            content+=           "   <div class=\"clear\">\n" +
                "        <h2 class='item-name'>الوصف</h2>\n" +
                "        <p class='right-paragraph'>" + response.descriptionMata + "</p>" +
                " <i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>"+
                "\n" +
                "    </div>\n" +
                "    <div class=\"clear\">\n" +
                "        <h2 class='item-name'>طول الوصف</h2>\n" +
                "    <p class='right-paragraph'>" + response.lengthDescription + " حرف</p>";

            if (response.checkLengthDescription === true) {
                content+= "  <i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>";
            }
            else if (response.checkLengthDescription === false) {
                content+="  <i class=\"fa fa-times-circle fail-mark\" aria-hidden=\"true\"></i>";
            }
           content+=         "    </div>\n" +
               "    <div class=\"clear\">\n" +
               "        <h2 class='item-name'>عدد الكلمات</h2>\n" +
               "    <p class='right-paragraph'>" + response.descriptionCount + "</p>\n" +
               "    </div>\n" +
               "    <div class=\"clear\">\n" +
               "        <h2 class='item-name'>الصفحة تحتوي علي وصف واحد فقط</h2>";
            if (!response.duplicateDescription === true) {
             content+= "  <i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>";
            }
            else if (!response.duplicateDescription === false) {
              content+="  <i class=\"fa fa-times-circle fail-mark\" aria-hidden=\"true\"></i>";
            }
           content+="<div class='clear'></div></div>";
        }
        else if (response.hasDescription === false) {
            content+=    "    <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>خطأ</h2>\n" +
                "        <p class='right-paragraph'>الصفحة لا تحتوي علي وسم الوصف</p>\n" +
                " <div class='clear'></div>   </div>";
        }
        document.getElementById("description-section").insertAdjacentHTML('beforeend',
            content
        );

    }

    // <!-- Keyword Result-->
    if (response.hasKeywords !== null && response.duplicateKeywords !== null) {
        if (response.hasKeywords === true) {
            document.getElementById("keywords-section").innerHTML = "";
            document.getElementById("keywords-section").className = "";
            document.getElementById("keywords-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">الكلمات المفتاحية</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasKeywords === false) {
            document.getElementById("keywords-section").innerHTML = "";
            document.getElementById("keywords-section").className = "";
            document.getElementById("keywords-section").insertAdjacentHTML('beforeend',
                '<div class="warn">\n' +
                '                <h1 class="item-title">الكلمات المفتاحية</h1>\n' +
                '            <i class="fa fa-exclamation-triangle big-warn" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('keywords-section').insertAdjacentHTML('beforeend',
            " <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        يعد هذا الوسم أحد وسوم Meta ، ولقد ألغي جوجل إستخدام هذا الوسم في خورزمياته منذ فتره طويله ولكن ياهو\n" +
            "    مازال يستخدم هذا الوسم بنسبه ضعيفه وأيضاً بعض محركات البحث الأخري\n" +
            "    </article>\n" +
            "    <div class=\"clear padding-top\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>لا تحاول الإكثار من الكلمات المفتاحيه أو شبيهاتها</p>\n" +
            "    </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>يجب أن يحتوي محتوي الصفحه علي الكلمات المفتاحية المستهدفة ولكن بصورة مقروءه جيداً للزائر</p>\n" +
            "    </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>يجب أن تحتوي الصفحه علي وسم (كلمات مفتاحيه) واحد فقط</p>\n" +
            "    </div>\n" +
            "    </div>"
        );
        if (response.hasKeywords === true) {
            document.getElementById('keywords-section').insertAdjacentHTML('beforeend',
                " <div class=\"clear\">\n" +
                "        <h2 class='item-name'>الكلمات المفتاحيه</h2>\n" +
                "    <p>" + response.keywordsMeta + "</p>\n" +
                "    </div>\n" +
                "    <div class=\"clear\">\n" +
                "        <h2 class='item-name'>طول الكلمات المفتاحيه</h2>\n" +
                "    <p>" + response.lengthKeywords + " حرف</p>\n" +
                "    </div>\n" +
                "    <div class=\"clear\">\n" +
                "        <h2 class='item-name'>عدد الكلمات</h2>\n" +
                "    <p>" + response.keywordsCount + "</p>\n" +
                "    </div>\n" +
                "    <div class=\"clear\">\n" +
                "        <h2 class='item-name'>الصفحة تحتوي علي وسم واحد فقط</h2>"
            );
            if (!response.duplicateKeywords === true) {
                document.getElementById('keywords-section').insertAdjacentHTML('beforeend',
                    "  <i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>"
                );
            }
            else if (!response.duplicateKeywords === false) {
                document.getElementById('keywords-section').insertAdjacentHTML('beforeend',
                    "  <i class=\"fa fa-times-circle fail-mark\" aria-hidden=\"true\"></i>"
                );
            }
            document.getElementById('keywords-section').insertAdjacentHTML('beforeend',
                "<div class='clear'></div></div>"
            );
        }
        else if (response.hasKeywords === false) {
            document.getElementById('keywords-section').insertAdjacentHTML('beforeend',
                " <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>ملحوظة</h2>\n" +
                "        <p>الصفحة لا تحتوي علي وسم الكلمات المفتاحية ولقد ألغي جوجل أهمية هذا الوسم ولكن ياهو ومحركات البحث\n" +
                "    الأخري مازالت تستخدمه في خوارزمياتها</p>\n" +
                "    </div>"
            );
        }
    }

// <!-- NewsKeyword Result-->
    if (response.hasNews_keywords !== null && response.duplicateNews_keywords !== null) {
        if (response.hasNews_keywords === true) {
            document.getElementById("newskeywords-section").innerHTML = "";
            document.getElementById("newskeywords-section").className = "";
            document.getElementById("newskeywords-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">الكلمات المفتاحية للأخبار</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasNews_keywords === false) {
            document.getElementById("newskeywords-section").innerHTML = "";
            document.getElementById("newskeywords-section").className = "";
            document.getElementById("newskeywords-section").insertAdjacentHTML('beforeend',
                '<div class="warn">\n' +
                '                <h1 class="item-title">الكلمات المفتاحية للأخبار</h1>\n' +
                '            <i class="fa fa-exclamation-triangle big-warn" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('newskeywords-section').insertAdjacentHTML('beforeend',
            "\n" +
            "    <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        بالإنجليزيه news_keywords يعد هذا الوسم أحد وسوم Meta ، وهو مهم جداً للمواقع الإخباريه و علي عكس وسم\n" +
            "    (الكلمات المفتاحية) مازال جوجل يستخدم هذا الوسم ولكن بمواقع الأخبار فقط\n" +
            "    </article>\n" +
            "    <div class=\"clear padding-top\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>لا تحاول الإكثار من الكلمات المفتاحيه أو شبيهاتها</p>\n" +
            "    </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>يجب أن يحتوي محتوي الصفحه علي الكلمات المفتاحية المستهدفة ولكن بصورة مقروءه جيداً للزائر</p>\n" +
            "    </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>يجب أن تحتوي الصفحه علي وسم واحد فقط</p>\n" +
            "    </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>يجب أن تستخدم هذا الوسم في صفحات الأخبار فقط</p>\n" +
            "    </div>\n" +
            "    </div>"
        );
        if (response.hasNews_keywords === true) {
            document.getElementById('newskeywords-section').insertAdjacentHTML('beforeend',
                " <div class=\"clear\">\n" +
                "        <h2 class='item-name'>الكلمات المفتاحيه للأخبار</h2>\n" +
                "    <p>" + response.news_keywordsMeta + "</p>\n" +
                "    </div>\n" +
                "    <div class=\"clear\">\n" +
                "        <h2 class='item-name'>طول الكلمات المفتاحيه</h2>\n" +
                "    <p>" + response.lengthNews_keywords + " حرف</p>\n" +
                "    </div>\n" +
                "    <div class=\"clear\">\n" +
                "        <h2 class='item-name'>عدد الكلمات</h2>\n" +
                "    <p>" + response.news_keywordsCount + "</p>\n" +
                "    </div>\n" +
                "    <div class=\"clear\">\n" +
                "        <h2 class='item-name'>الصفحة تحتوي علي وسم واحد فقط</h2>"
            );
            if (!response.duplicateNews_keywords === true) {
                document.getElementById('newskeywords-section').insertAdjacentHTML('beforeend',
                    "  <i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>"
                );
            }
            else if (!response.duplicateNews_keywords === false) {
                document.getElementById('newskeywords-section').insertAdjacentHTML('beforeend',
                    "  <i class=\"fa fa-times-circle fail-mark\" aria-hidden=\"true\"></i>"
                );
            }
            document.getElementById('newskeywords-section').insertAdjacentHTML('beforeend',
                "</div>"
            );
        }
        else if (response.hasNews_keywords === false) {
            document.getElementById('newskeywords-section').insertAdjacentHTML('beforeend',
                " <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>ملحوظة</h2>\n" +
                "  <p>هذا الوسم مهم جداً للمواقع الإخبارية وصفحات الأخبار فقط وأول من إستخدمه محرك بحث جوجل</p>" +
                "    </div>"
            );
        }
    }

// <!-- Robots Result-->
    if (response.hasRobots !== null) {
        if (response.hasRobots === true) {
            document.getElementById("robots-section").innerHTML = "";
            document.getElementById("robots-section").className = "";
            document.getElementById("robots-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">وسم Robots</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasRobots === false) {
            document.getElementById("robots-section").innerHTML = "";
            document.getElementById("robots-section").className = "";
            document.getElementById("robots-section").insertAdjacentHTML('beforeend',
                '<div class="warn">\n' +
                '                <h1 class="item-title">وسم Robots</h1>\n' +
                '            <i class="fa fa-exclamation-triangle big-warn" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('robots-section').insertAdjacentHTML('beforeend',
            "  <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        يعد وسم Meta Robots بديلاً عن ملف Robots الموجود في المجلد الرئيسي للموقع حيث بإمكانك إخبار محركات البحث\n" +
            "    برغبتك في فهرسة صفحه معينه وتتبعها أو أحد هذين الخيارين فقط أو علي العكس يمكنك إجبار عناكب محركات البحث\n" +
            "    علي عدم فهرسة وتتبع صفحات معينه\n" +
            "    </article>\n" +
            "    <div class=\"clear padding-top\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>يمكنك إخبار محركات البحث بشأن هذه الصفحه إما تسمح بفهرستها و تتبعها أو تتبعها فقط وعدم فهرستها أو\n" +
            "    فهرستها فقط </p>\n" +
            "    </div>\n" +
            "    </div>"
        );
        if (response.hasRobots === true) {
            document.getElementById('robots-section').insertAdjacentHTML('beforeend',
                "   <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>محتوي الوسم</h2>\n" +
                "    <p>" + response.robotsMeta + "</p>\n" +
                "    </div>"
            );
        }
        else if (response.hasRobots === false) {
            document.getElementById('robots-section').insertAdjacentHTML('beforeend',
                "   <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>ملحوظة</h2>\n" +
                "        <p>هذا الوسم يحدد كيف تريد محركات البحث أن تفعل تجاة هذة الصفحة</p>\n" +
                "    </div>"
            );
        }
    }
// <!-- Meta Result-->
    if (response.metas !== null) {
        progress(30);
        if (typeof response.metas !== 'undefined') {
            passedCount++;
            document.getElementById("meta-section").innerHTML = "";
            document.getElementById("meta-section").className = "";
            document.getElementById("meta-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">وسوم Meta</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (typeof response.metas === 'undefined') {
            errorsCount++;
            document.getElementById("meta-section").innerHTML = "";
            document.getElementById("meta-section").className = "";
            document.getElementById("meta-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">وسوم Meta</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('meta-section').insertAdjacentHTML('beforeend',
            " <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        تعد وسوم Meta أحد الأشياء التي تقرأها جميع الروبوتات بما فيها محركات البحث و روبوتات تطبيقات أخري\n" +
            "    </article>\n" +
            "    </div>"
        );

        if (typeof response.metas !== 'undefined') {
            var key;
            for (key in response.metas) {
                document.getElementById('meta-section').insertAdjacentHTML('beforeend',
                    "<div class=\"clear padding-bottom\">\n" +
                    "        <h2 class='item-name'>" + key + "</h2>\n" +
                    "    <p class='right-paragraph'>" + response.metas[key] + "</p>\n" +
                    "    </div>"
                );
            }
            document.getElementById('meta-section').insertAdjacentHTML('beforeend',
                "<div class='clear'></div>"
            );
        }
        else if (typeof response.metas === 'undefined') {
            document.getElementById('meta-section').insertAdjacentHTML('beforeend',
                "    <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>خطأ</h2>\n" +
                "        <p>لم نجد في هذة الصفحة أي وسم من وسوم Meta</p>\n" +
                "    </div>"
            );
        }
    }
// <!-- Canonical Result-->
    if (response.hasCanonical !== null) {
        if (response.hasCanonical === true) {
            passedCount++;
            document.getElementById("canonical-section").innerHTML = "";
            document.getElementById("canonical-section").className = "";
            document.getElementById("canonical-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">الرابط الأساسي Canonical</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasCanonical === false) {
            errorsCount++;
            document.getElementById("canonical-section").innerHTML = "";
            document.getElementById("canonical-section").className = "";
            document.getElementById("canonical-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">الرابط الأساسي Canonical</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('canonical-section').insertAdjacentHTML('beforeend',
            " <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        تعد أهمية هذا الوسم في أنه يخبر روبوتات محركات البحث بالرابط الأساسي للصفحه أو المقاله وهذا يزيل إمكانية\n" +
            "    أن يتعرض موقعك لمشكلة تكرار المحتوي\n" +
            "    </article>\n" +
            "    </div>"
        );

        if (response.hasCanonical === true) {
            document.getElementById('canonical-section').insertAdjacentHTML('beforeend',
                "      <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>الرابط الأساسي</h2>\n" +
                "    <p>" + response.canonical + "</p>\n" +
                "    </div>"
            );
        }
        else if (response.hasCanonical === false) {
            document.getElementById('canonical-section').insertAdjacentHTML('beforeend',
                "   <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>ملحوظة</h2>\n" +
                "        <p>عدم وجود هذا الوسم بصفحات موقعك يعرض موقعك لمشكلة تكرار المحتوي ولا سيما لو كانت الصفحة تستقبل\n" +
                "    متغيرات</p>\n" +
                "    </div>"
            );
        }
    }

// <!-- Heading Result-->
    if (response.hasGoodHeadings !== null) {
        progress(40);
        if (response.hasGoodHeadings === true && !response.hasManyH1 === true) {
            passedCount++;
            document.getElementById("headings-section").innerHTML = "";
            document.getElementById("headings-section").className = "";
            document.getElementById("headings-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">وسوم Headings</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasGoodHeadings === false || !response.hasManyH1 === false) {
            errorsCount++;
            document.getElementById("headings-section").innerHTML = "";
            document.getElementById("headings-section").className = "";
            document.getElementById("headings-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">وسوم Headings</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('headings-section').insertAdjacentHTML('beforeend',
            "   <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>يعد وسوم Headings بالإنجليزيه\n" +
            "    Headings Tags\n" +
            "    من أهم الوسوم التي تهتم بها محركات البحث لذا إحرص علي إستخدام الكلمات المفتاحية المستهدفة بين هذه الوسوم\n" +
            "    </article>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>إستخدم كلاً من الوسوم الأتيه H1 و H2 و H3 علي الأقل مره واحده</p>\n" +
            "    </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>إستخدم وسم H1 مره واحده في كل صفحه</p>\n" +
            "    </div>\n" +
            "\n" +
            "    </div>"
        );
        if (response.hasH1 === true) {
            document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                "    <div class=\"clear\">\n" +
                "        <h2 class='item-name'>عدد وسوم H1</h2>\n" +
                "    <p class='right-paragraph'>" + response.countH1 + "</p>"
            );

            if (!response.hasManyH1 === true) {
                document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                    "  <i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>"
                );
            }
            else if (!response.hasManyH1 === false) {
                document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                    "  <i class=\"fa fa-times-circle fail-mark\" aria-hidden=\"true\"></i>"
                );
            }
            document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                " </div>\n" +
                "    <div class=\"clear\">\n" +
                "        <h2 class='item-name'>وسوم H1</h2>" +
                "<button class='show-hide-btn' onclick=\"toggleShow('list1')\">عرض / إخفاء الكل</button>" +
                " <div class='clear'></div><ul>"
            );
            var key2;
            for (key2 in response.h1) {
                document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                    "<li class='list1 hidden-item'>" + response.h1[key2] + "</li>"
                );
            }
            document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                "</ul> </div>"
            );
        }
        if (response.hasH2 === true) {
            document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                "      <div class=\"clear\">\n" +
                "        <h2 class='item-name'>عدد وسوم H2</h2>\n" +
                "    <p>" + response.countH2 + "</p>\n" +
                "    </div>\n" +
                "    <div class=\"clear\">\n" +
                "        <h2 class='item-name'>وسوم H2</h2>" +
                "<button class='show-hide-btn' onclick=\"toggleShow('list2')\">عرض / إخفاء الكل</button>" +
                "<div class='clear'></div><ul>"
            );

            var key3;
            for (key3 in response.h2) {
                document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                    "<li class='list2 hidden-item'>" + response.h2[key3] + "</li>"
                );
            }
            document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                "</ul> </div>"
            );
        }

        if (response.hasH3 === true) {
            document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                "      <div class=\"clear\">\n" +
                "        <h2 class='item-name'>عدد وسوم H3</h2>\n" +
                "    <p>" + response.countH3 + "</p>\n" +
                "    </div>\n" +
                "    <div class=\"clear\">\n" +
                "        <h2 class='item-name'>وسوم H3</h2>" +
                "<button class='show-hide-btn' onclick=\"toggleShow('list3')\">عرض / إخفاء الكل</button>" +
                "<div class='clear'></div><ul>"
            );

            var key3;
            for (key3 in response.h3) {
                document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                    "<li class='list3 hidden-item'>" + response.h3[key3] + "</li>"
                );
            }
            document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                "</ul> </div>"
            );
        }

        if (response.hasH4 === true) {
            document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                "      <div class=\"clear\">\n" +
                "        <h2 class='item-name'>عدد وسوم H4</h2>\n" +
                "    <p>" + response.countH4 + "</p>\n" +
                "    </div>\n" +
                "    <div class=\"clear\">\n" +
                "        <h2 class='item-name'>وسوم H4</h2>" +
                "<button class='show-hide-btn' onclick=\"toggleShow('list4')\">عرض / إخفاء الكل</button>" +
                "<div class='clear'></div><ul>"
            );

            var key3;
            for (key3 in response.h4) {
                document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                    "<li class='list4 hidden-item'>" + response.h4[key3] + "</li>"
                );
            }
            document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                "</ul> </div>"
            );
        }

        if (response.hasH5 === true) {
            document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                "      <div class=\"clear\">\n" +
                "        <h2 class='item-name'>عدد وسوم H5</h2>\n" +
                "    <p>" + response.countH5 + "</p>\n" +
                "    </div>\n" +
                "    <div class=\"clear\">\n" +
                "        <h2 class='item-name'>وسوم H5</h2>" +
                "<button class='show-hide-btn' onclick=\"toggleShow('list5')\">عرض / إخفاء الكل</button>" +
                "<div class='clear'></div><ul>"
            );

            var key3;
            for (key3 in response.h5) {
                document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                    "<li class='list5 hidden-item'>" + response.h5[key3] + "</li>"
                );
            }
            document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                "</ul> </div>"
            );
        }

        if (response.hasH6 === true) {
            document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                "      <div class=\"clear\">\n" +
                "        <h2 class='item-name'>عدد وسوم H6</h2>\n" +
                "    <p>" + response.countH6 + "</p>\n" +
                "    </div>\n" +
                "    <div class=\"clear\">\n" +
                "        <h2 class='item-name'>وسوم H6</h2>" +
                "<button class='show-hide-btn' onclick=\"toggleShow('list6')\">عرض / إخفاء الكل</button>" +
                "<div class='clear'></div><ul>"
            );

            var key3;
            for (key3 in response.h6) {
                document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                    "<li class='list6 hidden-item'>" + response.h6[key3] + "</li>"
                );
            }
            document.getElementById('headings-section').insertAdjacentHTML('beforeend',
                "</ul> </div>"
            );
        }
    }

// <!-- TextHtmlRatio Result-->
    if (response.checkTextHtmlRatio !== null) {
        if (response.checkTextHtmlRatio === true) {
            passedCount++;
            document.getElementById("texthtmlratio-section").innerHTML = "";
            document.getElementById("texthtmlratio-section").className = "";
            document.getElementById("texthtmlratio-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">نسبة النص إلي كود Html</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.checkTextHtmlRatio === false) {
            errorsCount++;
            document.getElementById("texthtmlratio-section").innerHTML = "";
            document.getElementById("texthtmlratio-section").className = "";
            document.getElementById("texthtmlratio-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">نسبة النص إلي كود Html</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }

        document.getElementById('texthtmlratio-section').insertAdjacentHTML('beforeend',
            " <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        هذه النسبه ليست عاملاً أساسياً في ترتيب نتائج البحث ولكنها تساهم في تحسين عوامل أخري\n" +
            "    </article>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>نسبة النص إلي كود Html التي يوصي بها هي نسبة مابين 25% و 70%</p>\n" +
            "    </div>\n" +
            "    </div>"
        );
        document.getElementById('texthtmlratio-section').insertAdjacentHTML('beforeend',
            "  <div class=\"clear\">\n" +
            "        <h2 class='item-name'>نسبة النص إلي كود Html</h2>\n" +
            "    <p class='right-paragraph'>" + response.ratio + " %</p>"
        );

        if (response.checkTextHtmlRatio === true) {
            document.getElementById('texthtmlratio-section').insertAdjacentHTML('beforeend',
                "  <i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>"
            );
        }
        else if (response.checkTextHtmlRatio === false) {
            document.getElementById('texthtmlratio-section').insertAdjacentHTML('beforeend',
                "  <i class=\"fa fa-times-circle fail-mark\" aria-hidden=\"true\"></i>"
            );
        }
        document.getElementById('texthtmlratio-section').insertAdjacentHTML('beforeend',
            "</div><div class='clear'></div>"
        );
    }
// <!-- Img Result-->
    if (response.hasGoodImg !== null) {
        if (response.hasGoodImg === true) {
            passedCount++;
            document.getElementById("altimg-section").innerHTML = "";
            document.getElementById("altimg-section").className = "";
            document.getElementById("altimg-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">النص البديل للصور</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasGoodImg === false) {
            errorsCount++;
            document.getElementById("altimg-section").innerHTML = "";
            document.getElementById("altimg-section").className = "";
            document.getElementById("altimg-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">النص البديل للصور</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }

        document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
            " <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>يعد النص البديل للصور بالإنجليزية alt attribute in img tag\n" +
            "    طريقه لعرض صور معينه في نتائج بحث جمله معينه ، لذا ننصحك بأن يحتوي موقعك علي صور خاصه بك أو صور لديك حق\n" +
            "    نشرها و كتابة كلمات مفتاحيه واصفه للصور كنص بديل للصوره\n" +
            "    </article>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>لا تستخدم صور بدون نص بديل alt attribute</p>\n" +
            "    </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>ننصح أن يكون النص البديل يحتوي علي الكلمات المفتاحيه الخاصه بالصوره التي تستهدف الظهور في نتائج البحث\n" +
            "    بها</p>\n" +
            "    </div>\n" +
            "    </div>"
        );
        document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
            "    <div class=\"clear\">\n" +
            "        <h2 class='item-name'>عدد الصور بالصفحه</h2>\n" +
            "    <p class='right-paragraph'>" + response.imgCount + "</p>"
        );

        if (response.hasImg === true) {
            document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
                "  <i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>"
            );
        }
        else if (response.hasImg === false) {
            document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
                "  <i class=\"fa fa-times-circle warn-mark\" aria-hidden=\"true\"></i>"
            );
        }
        document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
            "   </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <h2 class='item-name'>عدد الصور التي تحتوي علي نص بديل</h2>\n" +
            "    <p class='right-paragraph'>" + response.altCount + "</p>"
        );

        if (response.hasAlt === true) {
            document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
                "  <i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>"
            );
        }
        else if (response.hasAlt === false) {
            document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
                "  <i class=\"fa fa-times-circle fail-mark\" aria-hidden=\"true\"></i>"
            );
        }
        document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
            "</div>\n" +
            "    <div class=\"clear\">\n" +
            "        <h2 class='item-name'>عدد الصور التي لا تحتوي علي نص بديل</h2>\n" +
            "    <p class='right-paragraph'>" + response.emptyAltCount + "</p>"
        );
        if (!response.hasEmptyAlt === true) {
            document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
                "  <i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>"
            );
        }
        else if (!response.hasEmptyAlt === false) {
            document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
                "  <i class=\"fa fa-times-circle fail-mark\" aria-hidden=\"true\"></i>"
            );
        }

        document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
            "   </div>"
        );

        if (typeof response.alt !== "undefined") {
            document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
                " <div class=\"clear\">\n" +
                "        <h2 class='item-name'>النصوص البديله</h2>" +
                "<button class='show-hide-btn' onclick=\"toggleShow('altImg')\">عرض / إخفاء الكل</button>" +
                "<div class='clear'></div> " +
                "<ul>"
            );
            var x;
            for (x in response.alt) {
                document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
                    "<li class='altImg hidden-item'>" + response.alt[x] + "</li>"
                );
            }
            document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
                "</ul></div>"
            );
        }
        if (typeof response.emptyAlt !== "undefined") {
            document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
                " <div class=\"clear\">\n" +
                "        <h2 class='item-name'>الصور التي لا تحتوي علي نصوص بديله</h2>" +
                "<button class='show-hide-btn' onclick=\"toggleShow('emptyAlt')\">عرض / إخفاء الكل</button>" +
                "<div class='clear'></div> " +
                "<ul>"
            );
            var x;
            for (x in response.emptyAlt) {
                document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
                    "<li class='emptyAlt hidden-item'><a href=\"" + response.emptyAlt[x].src + " \" target=\"_blank\">صورة" + response.emptyAlt[x].num + " </a></li>"
                );
            }
            document.getElementById('altimg-section').insertAdjacentHTML('beforeend',
                "</ul></div>"
            );
        }
    }
// <!-- frames Result-->
    if (response.hasFrame !== null) {
        if ((!response.hasIFrame && !response.hasFrameSet && !response.hasFrame ) === true) {
            passedCount++;
            document.getElementById("frames-section").innerHTML = "";
            document.getElementById("frames-section").className = "";
            document.getElementById("frames-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">الإطارات</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if ((!response.hasIFrame && !response.hasFrameSet && !response.hasFrame ) === false) {
            errorsCount++;
            document.getElementById("frames-section").innerHTML = "";
            document.getElementById("frames-section").className = "";
            document.getElementById("frames-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">الإطارات</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }

        document.getElementById('frames-section').insertAdjacentHTML('beforeend',
            " <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>تعد جميع وسوم الإطارات سواءاً frame أو frameset أو iframe وسوماً حساسه ويجب إستخدامها بحرص لأن\n" +
            "    الإستخدام الخاطيء لهذه الوسوم يضعف السيو حيث أن محركات البحث لا تستطيع فهرسة الصفحات التي تحتوي علي\n" +
            "    إطارات لأنها لا تتبع النسق المعروف للمواقع\n" +
            "    </article>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>لا تضع أحد مكونات الصفحه داخل هذه الأوسمه</p>\n" +
            "    </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>إستخدام هذة الإطارات بطريقة صحيحه مثل إدراج أحد المكونات الخارجيه من مواقع أخري لا تضر</p>\n" +
            "    </div>\n" +
            "    </div>"
        );
        document.getElementById('frames-section').insertAdjacentHTML('beforeend',
            "\n" +
            "    <div class=\"clear\">\n" +
            "        <h2 class='item-name'>عدد وسوم frame</h2>\n" +
            "    <p class='right-paragraph'>" + response.frameCount + "</p>"
        );
        if (!response.hasFrame === true) {
            document.getElementById('frames-section').insertAdjacentHTML('beforeend',
                "  <i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>"
            );
        }
        else if (!response.hasFrame === false) {
            document.getElementById('frames-section').insertAdjacentHTML('beforeend',
                "  <i class=\"fa fa-times-circle fail-mark\" aria-hidden=\"true\"></i>"
            );
        }
        document.getElementById('frames-section').insertAdjacentHTML('beforeend',
            " </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <h2 class='item-name'>عدد وسوم iframe</h2>\n" +
            "    <p class='right-paragraph'>" + response.iFrameCount + "</p>"
        );
        if (!response.hasIFrame === true) {
            document.getElementById('frames-section').insertAdjacentHTML('beforeend',
                "  <i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>"
            );
        }
        else if (!response.hasIFrame === false) {
            document.getElementById('frames-section').insertAdjacentHTML('beforeend',
                "  <i class=\"fa fa-times-circle fail-mark\" aria-hidden=\"true\"></i>"
            );
        }
        document.getElementById('frames-section').insertAdjacentHTML('beforeend',
            "  </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <h2 class='item-name'>عدد وسوم frameSet</h2>\n" +
            "    <p class='right-paragraph'>" + response.frameSetCount + "</p>"
        );

        if (!response.hasFrameSet === true) {
            document.getElementById('frames-section').insertAdjacentHTML('beforeend',
                "  <i class=\"fa fa-check-circle-o success-mark\" aria-hidden=\"true\"></i>"
            );
        }
        else if (!response.hasFrameSet === false) {
            document.getElementById('frames-section').insertAdjacentHTML('beforeend',
                "  <i class=\"fa fa-times-circle fail-mark\" aria-hidden=\"true\"></i>"
            );
        }
        document.getElementById('frames-section').insertAdjacentHTML('beforeend',
            " </div><div class='clear'></div>"
        );
    }
// <!-- SiteMap Result-->
    if (response.hasSiteMap !== null) {
        if (response.hasSiteMap === true) {
            passedCount++;
            document.getElementById("map-section").innerHTML = "";
            document.getElementById("map-section").className = "";
            document.getElementById("map-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">خريطة الموقع</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasSiteMap === false) {
            errorsCount++;
            document.getElementById("map-section").innerHTML = "";
            document.getElementById("map-section").className = "";
            document.getElementById("map-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">خريطة الموقع</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('map-section').insertAdjacentHTML('beforeend',
            "    <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        تكمن فائدة خريطة الموقع في أنها تخبر محركات البحث بهيكلة الموقع الخاص بك و بهذا يسهل علي محركات البحث\n" +
            "    معرفة الصفحات الجديده بموقعك و فهرستها\n" +
            "    </article>\n" +
            "    </div>"
        );
        if (response.hasSiteMap === true) {
            document.getElementById('map-section').insertAdjacentHTML('beforeend',
                "  <div class=\"clear\">\n" +
                "        <h2 class='item-name'>خريطة الموقع</h2>" +
                "<div class='clear'></div> <ul>"
            );
            var x;
            for (x in response.siteMap) {
                document.getElementById('map-section').insertAdjacentHTML('beforeend',
                    "<li>" + response.siteMap[x] + "</li>"
                );
            }
            document.getElementById('map-section').insertAdjacentHTML('beforeend',
                "</ul>    </div>"
            );
        }
        else if (response.hasSiteMap === false) {
            document.getElementById('map-section').insertAdjacentHTML('beforeend',
                " <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>خطأ</h2>\n" +
                "        <p>لم نجد خرائط لهذا الموقع</p>\n" +
                "    </div>"
            );
        }
    }
// <!-- robots.txt Result-->
    if (response.hasRobotsFile !== null) {
        if (response.hasRobotsFile === true) {
            passedCount++;
            document.getElementById("robotstxt-section").innerHTML = "";
            document.getElementById("robotstxt-section").className = "";
            document.getElementById("robotstxt-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">ملف robots.txt</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasRobotsFile === false) {
            errorsCount++;
            document.getElementById("robotstxt-section").innerHTML = "";
            document.getElementById("robotstxt-section").className = "";
            document.getElementById("robotstxt-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">ملف robots.txt</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('robotstxt-section').insertAdjacentHTML('beforeend',
            " <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        تكمن أهمية ملف robots.txt في أنه يخبر عناكب محركات البحث بالصفحات التي تود فهرستها والصفحات التي لا تود\n" +
            "    فهرستها كما يتيح لك طريقة لتحديد مكان خرائط الموقع\n" +
            "    </article>\n" +
            "    </div>"
        );
        if (response.hasRobotsFile === true) {
            document.getElementById('robotstxt-section').insertAdjacentHTML('beforeend',
                "     <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>رابط الملف</h2>\n" +
                "    <p>" + response.robotsFile + "</p>\n" +
                "    </div>"
            );
        }
        else if (response.hasRobotsFile === false) {
            document.getElementById('robotstxt-section').insertAdjacentHTML('beforeend',
                "    <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>خطأ</h2>\n" +
                "        <p>لم نجد ملف robots.txt الخاص بموقعك</p>\n" +
                "    </div>"
            );
        }
    }
// <!-- structuredData Result-->
    if (response.hasStructuredData !== null) {
        if (response.hasStructuredData === true) {
            passedCount++;
            document.getElementById("structuredData-section").innerHTML = "";
            document.getElementById("structuredData-section").className = "";
            document.getElementById("structuredData-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">البيانات المنظمه</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasStructuredData === false) {
            errorsCount++;
            document.getElementById("structuredData-section").innerHTML = "";
            document.getElementById("structuredData-section").className = "";
            document.getElementById("structuredData-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">البيانات المنظمه</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('structuredData-section').insertAdjacentHTML('beforeend',
            " <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        يعد استخدام بيانات الترميز على صفحات الويب طريقة فعالة لزيادة ظهورك لمحركات البحث والحصول على نسب نقر و\n" +
            "    ظهور أعلى، مما قد يؤدي بدوره إلى ترتيب أفضل.\n" +
            "    </article>\n" +
            "    </div>"
        );
        if (response.hasStructuredData === true) {
            document.getElementById('structuredData-section').insertAdjacentHTML('beforeend',
                "    <div class=\"clear\">\n" +
                "        <h2 class='item-name'>نوع البيانات</h2>"
            );
            if (response.hasMicroData === true) {
                document.getElementById('structuredData-section').insertAdjacentHTML('beforeend',
                    "<li>بيانات مصغره بالإنجليزيه Micro Data</li>"
                );
            }
            else if (response.hasRDFa === false) {
                document.getElementById('structuredData-section').insertAdjacentHTML('beforeend',
                    " <li>بيانات RDFa</li>"
                );
            }
            else if (response.hasJson === false) {
                document.getElementById('structuredData-section').insertAdjacentHTML('beforeend',
                    "<li>بيانات Json</li>"
                );
            }
            document.getElementById('structuredData-section').insertAdjacentHTML('beforeend',
                "<div class='clear'></div></div>"
            );
        }
        else if (response.hasStructuredData === false) {
            document.getElementById('structuredData-section').insertAdjacentHTML('beforeend',
                "   <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>خطأ</h2>\n" +
                "        <p>لم نجد أي نوع من البيانات المنظمه في هذه الصفحه</p>\n" +
                "   <div class='clear'></div> </div>"
            );
        }
    }
// <!-- microfromats Result-->
    if (response.hasMicroFormat !== null) {
        if (response.hasMicroFormat === true) {
            passedCount++;
            document.getElementById("microfromats-section").innerHTML = "";
            document.getElementById("microfromats-section").className = "";
            document.getElementById("microfromats-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">MicroFormats</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasMicroFormat === false) {
            errorsCount++;
            document.getElementById("microfromats-section").innerHTML = "";
            document.getElementById("microfromats-section").className = "";
            document.getElementById("microfromats-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">MicroFormats</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }

        document.getElementById('microfromats-section').insertAdjacentHTML('beforeend',
            "    <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        MicroFormats هي مجموعة من البنايات الصغيره ، وتنسيقات البيانات المفتوحة المصدر المصممه علي معايير واسعة\n" +
            "    الإستخدام ، تستخدم لتنظيم البيانات المرسله لمحركات البحث بصوره أكثر فعاليه.\n" +
            "    </article>\n" +
            "    </div>"
        );


        if (response.hasMicroFormat === true) {
            document.getElementById('microfromats-section').insertAdjacentHTML('beforeend',
                "        <div class=\"clear\">\n" +
                "        <p>لقد وجدنا بعض البيانات المنظمه تبعاً لموقع microformats.org</p>\n" +
                "    </div>\n"
            );
        }
        else if (response.hasMicroFormat === false) {
            document.getElementById('microfromats-section').insertAdjacentHTML('beforeend',
                "    <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>خطأ</h2>\n" +
                "        <p>لم نجد أي نوع من البيانات المنظمه تبعاً لموقع microformats.org في هذه الصفحه</p>\n" +
                "    </div>"
            );
        }
    }
// <!-- FormattedText Result-->
    if (response.hasFormattedText !== null) {
        if (response.hasFormattedText === true) {
            passedCount++;
            document.getElementById("FormattedText-section").innerHTML = "";
            document.getElementById("FormattedText-section").className = "";
            document.getElementById("FormattedText-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">نصوص منسقه</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasFormattedText === false) {
            errorsCount++;
            document.getElementById("FormattedText-section").innerHTML = "";
            document.getElementById("FormattedText-section").className = "";
            document.getElementById("FormattedText-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">نصوص منسقه</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('FormattedText-section').insertAdjacentHTML('beforeend',
            "    <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        لا بد أن تحتوي صفحة الويب علي نصوص منسقه وننصحك أن تنسق الكلمات المفتاحيه التي تستهدفها\n" +
            "    </article>\n" +
            "    </div>"
        );

        if (response.hasFormattedText === true) {


            if (typeof response.strongItems !== "undefined") {
                document.getElementById('FormattedText-section').insertAdjacentHTML('beforeend',
                    "<div class=\"clear\">\n" +
                    "        <h2 class='item-name'>نصوص Strong</h2><ul>"
                );
                var x;
                for (x in response.strongItems) {
                    document.getElementById('FormattedText-section').insertAdjacentHTML('beforeend',
                        "<li>" + response.strongItems[x] + "</li>"
                    );
                }
                document.getElementById('FormattedText-section').insertAdjacentHTML('beforeend',
                    "</ul></div>"
                );
            }
            else if (typeof response.emItems !== "undefined") {
                document.getElementById('FormattedText-section').insertAdjacentHTML('beforeend',
                    "<div class=\"clear\">\n" +
                    "        <h2 class='item-name'>نصوص em</h2><ul>"
                );
                var x;
                for (x in response.emItems) {
                    document.getElementById('FormattedText-section').insertAdjacentHTML('beforeend',
                        "<li>" + response.emItems[x] + "</li>"
                    );
                }
                document.getElementById('FormattedText-section').insertAdjacentHTML('beforeend',
                    "</ul></div>"
                );
            }
            else if (typeof response.iItems !== "undefined") {
                document.getElementById('FormattedText-section').insertAdjacentHTML('beforeend',
                    "<div class=\"clear\">\n" +
                    "        <h2 class='item-name'>نصوص i</h2><ul>"
                );
                var x;
                for (x in response.iItems) {
                    document.getElementById('FormattedText-section').insertAdjacentHTML('beforeend',
                        "<li>" + response.iItems[x] + "</li>"
                    );
                }
                document.getElementById('FormattedText-section').insertAdjacentHTML('beforeend',
                    "</ul></div>"
                );
            }
            else if (typeof response.bItems !== "undefined") {
                document.getElementById('FormattedText-section').insertAdjacentHTML('beforeend',
                    "<div class=\"clear\">\n" +
                    "        <h2 class='item-name'>نصوص b</h2><ul>"
                );
                var x;
                for (x in response.bItems) {
                    document.getElementById('FormattedText-section').insertAdjacentHTML('beforeend',
                        "<li>" + response.bItems[x] + "</li>"
                    );
                }
                document.getElementById('FormattedText-section').insertAdjacentHTML('beforeend',
                    "</ul></div>"
                );
            }
        }
        else if (response.hasFormattedText === false) {
            document.getElementById('FormattedText-section').insertAdjacentHTML('beforeend',
                "    <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>خطأ</h2>\n" +
                "        <p>لم نجد أي نص منسق في هذه الصفحه</p>\n" +
                "    </div>"
            );
        }
    }
// <!-- Flash Result-->
    if (response.hasFlash !== null) {
        if (!response.hasFlash === true) {
            passedCount++;
            document.getElementById("Flash-section").innerHTML = "";
            document.getElementById("Flash-section").className = "";
            document.getElementById("Flash-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">مكونات Flash</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (!response.hasFlash === false) {
            errorsCount++;
            document.getElementById("Flash-section").innerHTML = "";
            document.getElementById("Flash-section").className = "";
            document.getElementById("Flash-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">مكونات Flash</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('Flash-section').insertAdjacentHTML('beforeend',
            "   <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>يعد الفلاش من المكونات الغير قابله للفهرسه ولذلك لا ننصح بإستخدامه داخل صفحات الويب</article>\n" +
            "    </div>"
        );

        if (!response.hasFlash === true) {
            document.getElementById('Flash-section').insertAdjacentHTML('beforeend',
                "     <div class=\"clear padding-bottom\">\n" +
                "        <p>لم نجد مكونات تستخدم flash بداخل الصفحه</p>\n" +
                "    </div>\n"
            );
        }
        else if (!response.hasFlash === false) {
            document.getElementById('Flash-section').insertAdjacentHTML('beforeend',
                "  <div class=\"clear\">" +
                "       <h2 class='item-name'>خطأ</h2>" +
                "        <p>وجدنا بعض المكونات التي تعمل بتقنية flash بهذه الصفحه</p>" +
                "    </div>"
            );
        }
    }

    <!-- indexability Result-->
    if (response.isIndexAble !== null) {
        progress(50);
        if (response.isIndexAble === true) {
            passedCount++;
            document.getElementById("indexability-section").innerHTML = "";
            document.getElementById("indexability-section").className = "";
            document.getElementById("indexability-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">قابلية الفهرسه</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.isIndexAble === false) {
            errorsCount++;
            document.getElementById("indexability-section").innerHTML = "";
            document.getElementById("indexability-section").className = "";
            document.getElementById("indexability-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">قابلية الفهرسه</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }

        document.getElementById('indexability-section').insertAdjacentHTML('beforeend',
            "  <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>هذا الإختبار يعرض لك قابلية هذة الصفحه للفهرسه علماً بأن هذا الإختبار لا يشمل الصفحات الموجوده في\n" +
            "    ملف robots.txt\n" +
            "    </article>\n" +
            "    </div>"
        );

        if (response.isIndexAble === true) {
            document.getElementById('indexability-section').insertAdjacentHTML('beforeend',
                "        <div class=\"clear padding-bottom\">\n" +
                "        <p>لم نجد في الصفحه وسوم تمنع فهرسة الصفحه</p>\n" +
                "    </div>\n"
            );
        }
        else if (response.isIndexAble === false) {
            document.getElementById('indexability-section').insertAdjacentHTML('beforeend',
                "    <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>خطأ</h2>\n" +
                "        <p>وجدنا بعض الوسوم التي تمنع فهرسة الصفحه</p>\n" +
                "    </div>"
            );
        }
    }
    <!-- Language Result-->
    if (response.hasLanguage !== null) {
        if (response.hasLanguage === true) {
            passedCount++;
            document.getElementById("language-section").innerHTML = "";
            document.getElementById("language-section").className = "";
            document.getElementById("language-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">اللغة</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasLanguage === false) {
            errorsCount++;
            document.getElementById("language-section").innerHTML = "";
            document.getElementById("language-section").className = "";
            document.getElementById("language-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">اللغة</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('language-section').insertAdjacentHTML('beforeend',
            " <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article></article>\n" +
            "        <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>تحديد لغة الصفحة في كود Html للمواقع متعددة اللغات مهم جداً</p>\n" +
            "    </div>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>تحديد لغة الصفحة في رابط الصفحه للمواقع متعددة اللغات مهم جداً</p>\n" +
            "    </div>\n" +
            "    </div>"
        );

        if (response.hasLanguage === true) {
            document.getElementById('language-section').insertAdjacentHTML('beforeend',
                "  <div class=\"clear\">\n" +
                "        <h2 class='item-name'>لغة الصفحة</h2>\n" +
                "    <p>" + response.language + "</p>" +
                "<div class='clear'></div> </div>"
            );
        }
        else if (response.hasLanguage === false) {
            document.getElementById('language-section').insertAdjacentHTML('beforeend',
                " <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>خطأ</h2>\n" +
                "        <p>من المستحسن أن تحدد لغة الصفحه</p>\n" +
                " <div class='clear'></div>   </div>"
            );
        }
    }
// <!-- favicon Result-->
    if (response.hasFavicon !== null) {
        if (response.hasFavicon === true) {
            passedCount++;
            document.getElementById("favicon-section").innerHTML = "";
            document.getElementById("favicon-section").className = "";
            document.getElementById("favicon-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">أيقونة الموقع</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasFavicon === false) {
            errorsCount++;
            document.getElementById("favicon-section").innerHTML = "";
            document.getElementById("favicon-section").className = "";
            document.getElementById("favicon-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">أيقونة الموقع</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('favicon-section').insertAdjacentHTML('beforeend',
            "   <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        من المهم أن يكون لموقعك أيقونه أو شعار يميز صفحات موقعك عن غيرها أثناء تصفح الزائر لموقعك فهذا يؤثر علي\n" +
            "    تجربة المستخدم وإنطباعه عن موقعك\n" +
            "    </article>\n" +
            "    </div>"
        );

        if (response.hasFavicon === true) {
            document.getElementById('favicon-section').insertAdjacentHTML('beforeend',
                "   <div class=\"clear\">\n" +
                "        <h2  class='item-name'>أيقونة الموقع</h2>\n" +
                "    <img src=\"" + response.favicon + "\" alt=\"site logo\">\n" +
                " <div class='clear'></div>       </div>"
            );
        }
        else if (response.hasFavicon === false) {
            document.getElementById('favicon-section').insertAdjacentHTML('beforeend',
                "    <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>خطأ</h2>\n" +
                "        <p>لم نجد أيقونه لهذا الموقع</p>\n" +
                "<div class='clear'></div>     </div>"
            );
        }
    }
    <!-- View Port Result-->
    if (response.hasViewport !== null) {
        if (response.hasViewport === true) {
            document.getElementById("viewport-section").innerHTML = "";
            document.getElementById("viewport-section").className = "";
            document.getElementById("viewport-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">وسم Viewport</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasViewport === false) {
            document.getElementById("viewport-section").innerHTML = "";
            document.getElementById("viewport-section").className = "";
            document.getElementById("viewport-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">وسم Viewport</h1>\n' +
                '            <i class="fa fa-exclamation-triangle big-warn" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('viewport-section').insertAdjacentHTML('beforeend',
            "    <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        هذا الوسم ليس له علاقه بالسيو أو بتحسين محركات البحث ولكنه يحدد كيف يعرض المتصفح الصفحه علي أجهزة\n" +
            "    الهواتف الذكيه ويؤثر علي تجربة المستخدم\n" +
            "    </article>\n" +
            "    <div class=\"clear\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>قد يكون عدم وجود هذا الوسم يؤدي إلي تجربة مستخدم سيئه</p>\n" +
            "    </div>\n" +
            "    </div>"
        );
        if (response.hasViewport === true) {
            document.getElementById('viewport-section').insertAdjacentHTML('beforeend',
                "        <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>محتوي الوسم</h2>\n" +
                "    <p>" + response.viewportMeta + "</p>\n" +
                "    </div>"
            );
        }
        else if (response.hasViewport === false) {
            document.getElementById('viewport-section').insertAdjacentHTML('beforeend',
                "    <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>ملحوظة</h2>\n" +
                "        <p>هذا الوسم ليس له علاقة بالسيو ولكنه يتحكم في كيفية عرض الصفحة علي أجهزة الهواتف الذكية</p>\n" +
                "    </div>"
            );
        }
    }
// <!-- AMP Result-->
    if (response.hasAmpLink !== null) {
        if (response.hasAmpLink === true) {
            passedCount++;
            document.getElementById("AMP-section").innerHTML = "";
            document.getElementById("AMP-section").className = "";
            document.getElementById("AMP-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">صفحة الجوّال المسرَّعة</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasAmpLink === false) {
            errorsCount++;
            document.getElementById("AMP-section").innerHTML = "";
            document.getElementById("AMP-section").className = "";
            document.getElementById("AMP-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">صفحة الجوّال المسرَّعة</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('AMP-section').insertAdjacentHTML('beforeend',
            "    <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        تمثل صفحة الجوّال المسرَّعة بالإنجليزيه Accelerated Mobile Pages (التي يُشار إليها اختصارًا بـ AMP)\n" +
            "    صفحات ويب مصمَّمة وفقًا لمواصفات البرامج المفتوحة المصدر. ويتم تخزين صفحات AMP التي تم التحقق من صحتها\n" +
            "    في ذاكرة التخزين المؤقت لصفحات AMP من Google؛ وهو ما يتيح عرضها بشكل أسرع.\n" +
            "    </article>\n" +
            "    </div>"
        );

        if (response.hasAmpLink === true) {
            document.getElementById('AMP-section').insertAdjacentHTML('beforeend',
                " <div class=\"clear\">\n" +
                "        <h2 class='item-name'>رابط صفحة الجوّال المسرَّعة</h2>\n" +
                "    <p>" + response.ampLink + "</p>" +
                " </div>"
            );
        }
        else if (response.hasAmpLink === false) {
            document.getElementById('AMP-section').insertAdjacentHTML('beforeend',
                "    <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>خطأ</h2>\n" +
                "        <p>هذه الصفحة لا تحتوي علي رابط لصفحة الجوّال المسرَّعة</p>\n" +
                "    </div>"
            );
        }
    }
    <!-- openGraph Result-->
    if (response.hasOG !== null) {
        if (response.hasOG === true) {
            passedCount++;
            document.getElementById("openGraph-section").innerHTML = "";
            document.getElementById("openGraph-section").className = "";
            document.getElementById("openGraph-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">بروتوكول Open Graph</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasOG === false) {
            errorsCount++;
            document.getElementById("openGraph-section").innerHTML = "";
            document.getElementById("openGraph-section").className = "";
            document.getElementById("openGraph-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">بروتوكول Open Graph</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('openGraph-section').insertAdjacentHTML('beforeend',
            "     <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        بروتوكول Open Graph يتيح للصفحات أن تمتلك نفس الوطائف التي تمتلكها كائنات facebook\n" +
            "                ، فإذا أردت أن تظهر روابط موقعك بشكل جيد داخل facebook فعليك إستخدام هذا البروتوكول\n" +
            "    </article>\n" +
            "    </div>"
        );

        if (response.hasOG === true) {
            var x;
            for (x in response.openGraph) {
                document.getElementById('openGraph-section').insertAdjacentHTML('beforeend',
                    " <div class=\"clear\">\n" +
                    "        <h2 class='item-name'>" + x + "</h2>\n" +
                    "    <p>" + response.openGraph[x] + "</p>" +
                    " </div>"
                );
            }
            document.getElementById('openGraph-section').insertAdjacentHTML('beforeend',
                "<div class='clear'></div>  "
            );
        }
        else if (response.hasOG === false) {
            document.getElementById('openGraph-section').insertAdjacentHTML('beforeend',
                "  <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>خطأ</h2>\n" +
                "        <p>هذه الصفحة لا تحتوي علي بروتوكول Open Graph</p>\n" +
                "    </div> "
            );
        }
    }

// <!-- TwitterCard Result-->
    if (response.hasTwitterCard !== null) {
        if (response.hasTwitterCard === true) {
            passedCount++;
            document.getElementById("TwitterCard-section").innerHTML = "";
            document.getElementById("TwitterCard-section").className = "";
            document.getElementById("TwitterCard-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">كرت Twitter</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasTwitterCard === false) {
            errorsCount++;
            document.getElementById("TwitterCard-section").innerHTML = "";
            document.getElementById("TwitterCard-section").className = "";
            document.getElementById("TwitterCard-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">كرت Twitter</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('TwitterCard-section').insertAdjacentHTML('beforeend',
            "     <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>\n" +
            "        كرت Twitter بالإنجليزيه Twitter Cardيتيح للصفحات أن تضيف عنوان و وصف و صوره للرابط داخل موقع Twitter\n" +
            "    </article>\n" +
            "    </div> "
        );

        if (response.hasTwitterCard === true) {
            var x;
            for (x in response.twitterCard) {
                document.getElementById('TwitterCard-section').insertAdjacentHTML('beforeend',
                    " <div class=\"clear\">\n" +
                    "        <h2 class='item-name'>" + x + "</h2>\n" +
                    "    <p>" + response.twitterCard[x] + "</p>" +
                    " </div>"
                );
            }
            document.getElementById('TwitterCard-section').insertAdjacentHTML('beforeend',
                "<div class='clear'></div>  "
            );
        }
        else if (response.hasTwitterCard === false) {
            document.getElementById('TwitterCard-section').insertAdjacentHTML('beforeend',
                "  <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>خطأ</h2>\n" +
                "        <p>هذه الصفحة لا تحتوي علي كرت Twitter</p>\n" +
                "    </div> "
            );
        }
    }

// <!-- Server info Result-->
    if (response.hasIpAddress !== null) {
        document.getElementById("serverInfo-section").innerHTML = "";
        document.getElementById("serverInfo-section").className = "";
        document.getElementById('serverInfo-section').insertAdjacentHTML('beforeend',
            "        <div class=\"warn\">\n" +
            "        <h1 class='item-title'>معلومات عن الخادم</h1>\n" +
            "    <i class=\"fa fa-exclamation-triangle big-warn\" aria-hidden=\"true\"></i>\n" +
            "        </div>\n" +
            "        <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article></article>\n" +
            "        <div class=\"clear\">\n" +
            "        <p>هذه بعض المعلومات التي لدينا عن الخادم الذي يستضيف موقعك</p>\n" +
            "    </div>\n" +
            "\n" +
            "    </div>"
        );

        if (response.hasIpAddress === true) {
            document.getElementById('serverInfo-section').insertAdjacentHTML('beforeend',
                " <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>عنوان IP</h2>\n" +
                "    <p>" + response.IpAddress + "</p>\n" +
                "    </div>"
            );
        }
        if (response.hasCountry === true && response.country !== null) {
            document.getElementById('serverInfo-section').insertAdjacentHTML('beforeend',
                "       <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>بلد الخادم</h2>\n" +
                "    <p>" + response.country + "</p>\n" +
                "    </div>"
            );
        }
        if (response.hasCity === true && response.city !== null) {
            document.getElementById('serverInfo-section').insertAdjacentHTML('beforeend',
                "       <div class=\"clear\">\n" +
                "        <h2 class='item-name'>مدينة الخادم</h2>\n" +
                "    <p>" + response.city + "</p>\n" +
                "    </div>"
            );
        }
        document.getElementById('serverInfo-section').insertAdjacentHTML('beforeend',
            "       <div class=\"clear\"></div>"
        );
    }
// <!-- DocType Result-->

    if (response.hasDocType !== null) {
        if (response.hasDocType === true) {
            passedCount++;
            document.getElementById("doctype-section").innerHTML = "";
            document.getElementById("doctype-section").className = "";
            document.getElementById("doctype-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">نوع الصفحه</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasDocType === false) {
            errorsCount++;
            document.getElementById("doctype-section").innerHTML = "";
            document.getElementById("doctype-section").className = "";
            document.getElementById("doctype-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">نوع الصفحه</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('doctype-section').insertAdjacentHTML('beforeend',
            "    <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article></article>\n" +
            "        <div class=\"clear padding-top\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>تحديد نوع الصفحه يساعد المتصفح علي عرض الصفحه بالصوره المطلوبه</p>\n" +
            "    </div>" +
            "    </div>"
        );

        if (response.hasDocType === true) {

            document.getElementById('doctype-section').insertAdjacentHTML('beforeend',
                "  <div class=\"clear\">\n" +
                "        <h2 class='item-name'>نوع الصفحه</h2>\n" +
                "    <p>" + response.docType + "</p>" +
                " <div class='clear'></div></div>  "
            );
        }
        else if (response.hasDocType === false) {
            document.getElementById('doctype-section').insertAdjacentHTML('beforeend',
                "  <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>خطأ</h2>\n" +
                "        <p>من المستحسن أن تحدد نوع الصفحه</p>\n" +
                " <div class='clear'></div>  </div> "
            );
        }
    }

// <!-- Encoding Result-->
    if (response.hasEncoding !== null) {
        if (response.hasEncoding === true) {
            passedCount++;
            document.getElementById("encoding-section").innerHTML = "";
            document.getElementById("encoding-section").className = "";
            document.getElementById("encoding-section").insertAdjacentHTML('beforeend',
                '<div class="success">\n' +
                '                <h1 class="item-title">ترميز الصفحه</h1>\n' +
                '            <i class="fa fa-check-circle-o big-success" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        else if (response.hasEncoding === false) {
            errorsCount++;
            document.getElementById("encoding-section").innerHTML = "";
            document.getElementById("encoding-section").className = "";
            document.getElementById("encoding-section").insertAdjacentHTML('beforeend',
                '<div class="fail">\n' +
                '                <h1 class="item-title">ترميز الصفحه</h1>\n' +
                '            <i class="fa fa-times-circle big-fail" aria-hidden="true"></i>\n' +
                '                </div>'
            );
        }
        document.getElementById('encoding-section').insertAdjacentHTML('beforeend',
            "     <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article></article>\n" +
            "        <div class=\"clear padding-top\">\n" +
            "        <i class=\"fa fa-check-circle-o success-mark info\" aria-hidden=\"true\"></i>\n" +
            "        <p>تحديد ترميز الصفحه يساعد المتصفح علي عرض الصفحه بدون تعقيدات ويقوي السيو</p>\n" +
            "    </div>" +
            "    </div>"
        );

        if (response.hasEncoding === true) {

            document.getElementById('encoding-section').insertAdjacentHTML('beforeend',
                "  <div class=\"clear\">\n" +
                "        <h2 class='item-name'>ترميز الصفحه</h2>\n" +
                "    <p>" + response.encoding + "</p>" +
                " <div class='clear'></div></div>  "
            );
        }
        else if (response.hasEncoding === false) {
            document.getElementById('encoding-section').insertAdjacentHTML('beforeend',
                "  <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>خطأ</h2>\n" +
                "        <p>من المستحسن أن تحدد ترميز الصفحه</p>\n" +
                " <div class='clear'></div>  </div> "
            );
        }
    }
// <!-- URl redirect Result-->
    if (response.redirectStatus !== null && response.URLRedirects !== null) {
        document.getElementById("redirects-section").innerHTML = "";
        document.getElementById("redirects-section").className = "";
        document.getElementById("redirects-section").insertAdjacentHTML('beforeend',
            "      <div class=\"warn\">\n" +
            "        <h1 class='item-title'>تحويلات الرابط</h1>\n" +
            "    <i class=\"fa fa-exclamation-triangle big-warn\" aria-hidden=\"true\"></i>\n" +
            "        </div>\n" +
            "        <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>إليك قائمه بعمليات التحويلات بكود الحاله التي صارت علي الرابط الخاص بالصفحه</article>\n" +
            "    </div>\n"
        );
        content = "<div class=\"col-lg-3\">";
        var x;
        for (x in response.redirectStatus) {
            content +=
                " <p class=\"clear my-blue right-paragraph\">" + response.redirectStatus[x] + "</p>";

        }
        content +=
            "    </div>" +
            "    <div class=\"col-lg-9\">";

        var x;
        for (x in response.URLRedirects) {
            content +=
                " <p class=\"clear right-paragraph\">" + response.URLRedirects[x] + "</p>";

        }
        content +=
            "</div></div><div class=\"clear\"></div>";
        document.getElementById('redirects-section').insertAdjacentHTML('beforeend',
            content
        );
    }

// <!-- URls analysis Result-->
    if (response.defaultRel !== null ||
        response.anchorCount !== null ||
        response.aHref !== null) {
        document.getElementById("linkanalysis-section").innerHTML = "";
        document.getElementById("linkanalysis-section").className = "";
        content = '';
        content += " <div class=\"warn\">\n" +
            "        <h1 class='item-title'>تحليل الروابط</h1>\n" +
            "    <i class=\"fa fa-exclamation-triangle big-warn\" aria-hidden=\"true\"></i>\n" +
            "        </div>\n" +
            "        <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>تفاصيل مهمه عن الروابط داخل الصفحة</article>\n" +
            "    </div>";
        if (typeof response.defaultRel !== "undefined" && response.defaultRel !== null) {
            content += "<div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>نوع الرابط الإفتراصي</h2>\n" +
                "    <p>" + response.defaultRel + "</p>\n" +
                "    </div>";
        }
        content += "\n" +
            "    <div class=\"clear padding-bottom\">\n" +
            "        <h2 class='item-name'>عدد الروابط في الصفحه</h2>\n" +
            "    <p>" + response.anchorCount + "</p>\n" +
            "    </div>\n" +
            "    <table id='link-table'>\n" +
            "    <thead>\n" +
            "    <tr class='my-row'>\n" +
            "    <th class=\"table-data col1links\">الرابط</th>\n" +
            "        <th class=\"table-data col2links\">نص الرابط</th>\n" +
            "    <th class=\"table-data col3links\">نوع الرابط</th>\n" +
            "    </tr>\n" +
            "    </thead>\n" +
            "    <tbody>";

        for (x in response.aHref) {
            content += "<tr class='my-row'>" +
                "    <td class=\"table-data col1links\"><a target='_blank' href='" + response.aHref[x] + "'> " + decodeURI(response.aHref[x]) + "</a></td>\n" +
                "    <td class=\"table-data col2links\">" + response.aText[x] + "</td>\n" +
                "    <td class=\"table-data col3links\">" + response.aStatus[x] + "</td>\n" +
                "    </tr>";
        }
        content += " </tbody>" +
            "    </table>" +
            "    <div class=\"clear\"></div>";

        document.getElementById('linkanalysis-section').insertAdjacentHTML('beforeend',
            content
        );
    }

// أليكسا Alexa

    if (response.hasGlobalAlexaRank !== null && (reportURL.indexOf("load-report")>=0) ===true) {
        progress(60);
        content = '';
        document.getElementById("alexa-section").innerHTML = "";
        document.getElementById("alexa-section").className = "";

        content += " <div class=\"warn\">\n" +
            "        <h1 class='item-title'>أليكسا Alexa</h1>\n" +
            "    <i class=\"fa fa-exclamation-triangle big-warn\" aria-hidden=\"true\"></i>\n" +
            "        </div>\n" +
            "        <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>تفاصيل مهمه عن زوار الموقع و ترتيب الموقع في أليكسا</article>\n" +
            "    </div>";

        if (response.hasGlobalAlexaRank === true && response.globalAlexaRank !== null) {
            content += "     <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>الترتيب العالمي</h2>\n" +
                "    <p>" + response.globalAlexaRank + "</p>\n" +
                "    </div>";
        }

        if (response.hasAlexaReach === true && response.alexaReach !== null) {
            content += "     <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>عدد الزوار المتوقع</h2>\n" +
                "    <p>" + response.alexaReach + "</p>\n" +
                "    </div>";
        }

        if (response.hasCountryName === true && response.countryName !== null) {
            content += "     <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>بلد الموقع</h2>\n" +
                "    <p>" + response.countryName + "</p>\n" +
                "    </div>";
        }

        if (response.hasCountryRank === true && response.countryRank !== null) {
            content += "     <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>الترتيب المحلي</h2>\n" +
                "    <p>" + response.countryRank + "</p>\n" +
                "    </div>";
        }

// if(response.hasCountryCode === true && response.countryCode !== null){
//     content+="     <div class=\"clear padding-bottom\">\n" +
//         "        <h2 class='item-name'>كود البلد</h2>\n" +
//         "    <p>"+response.countryCode+"</p>\n" +
//         "    </div>";
// }

        if (response.hasRankDelta === true && response.rankDelta !== null) {
            content += "     <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>مقدار التغير في الترتيب</h2>\n" +
                "    <p>" + response.rankDelta + "</p>\n" +
                "    </div>";
        }

        document.getElementById('alexa-section').insertAdjacentHTML('beforeend',
            content
        );
    }

// metrics
    if ((response.hasPageRank !== null || response.mozMetrics !== null) && (reportURL.indexOf("load-report")>=0) ===true){
        progress(65);
        content = '';
        document.getElementById("metrics-section").innerHTML = "";
        document.getElementById("metrics-section").className = "";

        content += " <div class=\"warn\">\n" +
            "        <h1 class='item-title'>مقاييس الموقع Metrics</h1>\n" +
            "    <i class=\"fa fa-exclamation-triangle big-warn\" aria-hidden=\"true\"></i>\n" +
            "        </div>\n" +
            "        <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>هذه جميع المقاييس و المعلومات التي حصلنا عليها عن موقعك</article>\n" +
            "    </div>";

        if (response.hasPageRank === true && response.pageRank !== null) {
            content += "     <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>ترتيب الصفحه PageRank</h2>\n" +
                "    <p>" + response.pageRank + "</p>\n" +
                "    </div>";
        }

        if (response.hasRankSignalsUniqueDomainLinksCount === true
            && response.rankSignalsUniqueDomainLinksCount !== null) {
            content += "     <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>عدد المواقع التي تشير لموقعك</h2>\n" +
                "    <p>" + response.rankSignalsUniqueDomainLinksCount + "</p>\n" +
                "    </div>";
        }

        if (response.hasRankSignalsTotalBackLinks === true && response.rankSignalsTotalBackLinks !== null) {
            content += "     <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>عدد الباك لينكس BackLinks</h2>\n" +
                "    <p>" + response.rankSignalsTotalBackLinks + "</p>\n" +
                "    </div>";
        }

        if (response.hasAlexaBackLinksCount === true && response.alexaBackLinksCount !== null) {
            content += "     <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>عدد الباك لينكس في أليكسا</h2>\n" +
                "    <p>" + response.alexaBackLinksCount + "</p>\n" +
                "    </div>";
        }

        if (response.hasMozMetrics === true && response.mozMetrics !== null) {
            content += "     <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>عدد الباك لينكس في Moz</h2>\n" +
                "    <p>" + response.mozMetrics['Links'] + "</p>\n" +
                "    </div>";
            content += "     <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>عدد الباك لينكس القوية في Moz</h2>\n" +
                "    <p>" + response.mozMetrics['External Equity Links'] + "</p>\n" +
                "    </div>";
            content += "     <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>MozRank للنطاق</h2>\n" +
                "    <p>" + response.mozMetrics['MozRank: URL'] + "</p>\n" +
                "    </div>";
            content += "     <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>MozRank للنطاق الفرعي</h2>\n" +
                "    <p>" + response.mozMetrics['MozRank: Subdomain'] + "</p>\n" +
                "    </div>";
            content += "     <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>دومين اثورتي DA</h2>\n" +
                "    <p>" + response.mozMetrics['Domain Authority'] + "</p>\n" +
                "    </div>";
            content += "     <div class=\"clear padding-bottom\">\n" +
                "        <h2 class='item-name'>بيج اثورتى PA</h2>\n" +
                "    <p>" + response.mozMetrics['Page Authority'] + "</p>\n" +
                "    </div>";
        }

        document.getElementById('metrics-section').insertAdjacentHTML('beforeend',
            content
        );
    }

// Backlinks
    if ((response.mozLinks !== null || response.olpLinks !== null ||
        response.alexaBackLinks !== null) && (reportURL.indexOf("load-report")>=0) ===true){
        progress(70);
        content = '';
        document.getElementById("backlinks-section").innerHTML = "";
        document.getElementById("backlinks-section").className = "";

        content += " <div class=\"warn\">\n" +
            "        <h1 class='item-title'>الباك لينكس Backlinks</h1>\n" +
            "    <i class=\"fa fa-exclamation-triangle big-warn\" aria-hidden=\"true\"></i>\n" +
            "        </div>\n" +
            "        <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>هذة جميع الباك لينكس التي تشير لموقعك و التي إستطعنا إيجادها</article>\n" +
            "    </div>";

        content +=
            "    <table id='link-table'>\n" +
            "    <thead>\n" +
            "    <tr class='my-row'>\n" +
            "    <th class=\"table-data col1bklinks\">الباك لينك</th>\n" +
            "        <th class=\"table-data col2bklinks\">رابط موقعك المشار إليه</th>\n" +
            "    <th class=\"table-data col3bklinks\">نص الباك لينك</th>\n" +
            "    </tr>\n" +
            "    </thead>\n" +
            "    <tbody>";

        for (x in response.mozLinks) {
            content += "<tr class='my-row'>" +
                "    <td class=\"table-data col1bklinks\"><a target='_blank' href='" + response.mozLinks[x]['Source URL'] + "'> " + decodeURI(response.mozLinks[x]['Source URL']) + "</a></td>\n" +
                "    <td class=\"table-data col2bklinks\"><a target='_blank' href='" + response.mozLinks[x]['Target URL'] + "'> " + decodeURI(response.mozLinks[x]['Target URL']) + "</a></td>\n" +
                "    <td class=\"table-data col3bklinks\">" + response.mozLinks[x]['Anchor Text'] + "</td>\n" +
                "    </tr>";
        }

        for (x in response.olpLinks) {
            content += "<tr class='my-row'>" +
                "    <td class=\"table-data col1bklinks\"><a target='_blank' href='" + response.olpLinks[x] + "'> " + decodeURI(response.olpLinks[x]) + "</a></td>\n" +
                "    <td class=\"table-data col2bklinks\"><p>--</p></td>\n" +
                "    <td class=\"table-data col3bklinks\"><p>--</p></td>\n" +
                "    </tr>";
        }

        for (x in response.alexaBackLinks) {
            content += "<tr class='my-row'>" +
                "    <td class=\"table-data col1bklinks\"><a target='_blank' href='" + response.alexaBackLinks[x] + "'> " + decodeURI(response.alexaBackLinks[x]) + "</a></td>\n" +
                "    <td class=\"table-data col2bklinks\"><p>--</p></td>\n" +
                "    <td class=\"table-data col3bklinks\"><p>--</p></td>\n" +
                "    </tr>";
        }
        content += " </tbody>" +
            "    </table>" +
            "    <div class=\"clear\"></div>";

        document.getElementById('backlinks-section').insertAdjacentHTML('beforeend',
            content
        );
    }
// pageinsightDesk
    if ((response.pageInsightDesktop !== null ||
        response.problemsListDesktop !== null) && (reportURL.indexOf("load-report")>=0) ===true) {
        progress(80);
        content = '';
        document.getElementById("pageinsightDesk-section").innerHTML = "";
        document.getElementById("pageinsightDesk-section").className = "";

        content += " <div class=\"warn\">\n" +
            "        <h1 class='item-title'>إحصاءات سرعة الصفحة (سطح المكتب)</h1>\n" +
            "    <i class=\"fa fa-exclamation-triangle big-warn\" aria-hidden=\"true\"></i>\n" +
            "        </div>\n" +
            "        <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>يمكنك دائماً التعديل على محتويات صفحات الموقع سواء كانت صور أو JavaScript أو CSS أو HTML لتحسين تجربة المستخدم في موقعك\n</article>\n" +
            "    </div>";

        content += "     <div class=\"clear padding-bottom\">\n" +
            "        <h2 class='item-name'>السرعة</h2>\n" +
            "    <p>" + response.pageInsightDesktop['speed'] + " %</p>\n" +
            "    </div>";

        content += "     <div class=\"clear padding-bottom\">\n" +
            "        <h2 class='item-name'>إحصاءات الصفحة</h2>\n" +
            "    </div>";

        content +=
            "    <table id='link-table'>\n" +
            "    <thead>\n" +
            "    <tr class='my-row'>\n" +
            "    <th class=\"table-data col1pmDesk\">الإحصاء</th>\n" +
            "        <th class=\"table-data col2pmDesk\">قيمته</th>\n" +
            "    </tr>\n" +
            "    </thead>\n" +
            "    <tbody>";

        for (x in response.pageInsightDesktop['pageStats']) {
            switch (x) {
                case "numberResources":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد الموارد</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "numberHosts":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد الخوادم</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "totalRequestBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم الطلب (بايت)</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "numberStaticResources":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد الموارد الثابتة</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "htmlResponseBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم كود HTML الغير مضغوطه (بايب)</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "textResponseBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم النص الغير مضغوط (بايت)</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "overTheWireResponseBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد البايت المضغوطة بإستخدام gZip</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "cssResponseBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم موارد css الغير مضغوطة (بايت)</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "imageResponseBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم الصور (بايت)</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "javascriptResponseBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم الجافاسكريبت الغير مضغوطة (بايت)</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "flashResponseBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم موارد الفلاش (بايت)</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "otherResponseBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم موارد الصفحة المتبقية (بايت)</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "numberJsResources":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد موارد جافاسكريبت</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "numberCssResources":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد موارد Css</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "numberRobotedResources":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد كل الموارد</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "numberTransientFetchFailureResources":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد الموارد التي فشل إرسالها</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "numTotalRoundTrips":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد مرات الإرسال ذهابا وإيابا</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "numRenderBlockingRoundTrips":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد مرات الإرسال لعرض الموارد المحظورة</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "cms":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">نظام إدارة المحتوي</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                default:
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">" + x + "</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
            }
        }

        content += " </tbody>" +
            "    </table>" +
            "    <div class=\"clear\"></div>";

        content += "     <div class=\"clear padding-bottom padding-top\">\n" +
            "        <h2 class='item-name'>اقتراحات التحسين</h2>\n" +
            "    </div>";

        content +=
            "    <table id='link-table'>\n" +
            "    <thead>\n" +
            "    <tr class='my-row'>\n" +
            "    <th class=\"table-data col1pmDesk\">الإقتراح</th>\n" +
            "        <th class=\"table-data col2pmDesk\">نسبة التحسين</th>\n" +
            "    </tr>\n" +
            "    </thead>\n" +
            "    <tbody>";

        for (x in response.problemsListDesktop) {
            switch (response.problemsListDesktop[x]) {
                case "Leverage browser caching":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">تحسين التخزين المؤقت للمتصفح</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.impactsListDesktop[x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "Reduce server response time":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">تقليل وقت استجابة الخادم</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.impactsListDesktop[x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "Minify CSS":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">تصغير Css</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.impactsListDesktop[x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "Eliminate render-blocking JavaScript and CSS in above-the-fold content":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">التخلص من عناصر جافا سكريبت و Css التي تحظر عرض المحتوى في الجزء العلوي</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.impactsListDesktop[x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "Optimize images":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">تحسين الصور</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.impactsListDesktop[x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "Prioritize visible content":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">تحديد أولوية المحتوى المرئي</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.impactsListDesktop[x] + "</td>\n" +
                        "    </tr>";
                    break;
                default:
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">" + response.problemsListDesktop[x] + "</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.impactsListDesktop[x] + "</td>\n" +
                        "    </tr>";
            }
        }

        content += " </tbody>" +
            "    </table>" +
            "    <div class=\"clear\"></div>";


        document.getElementById('pageinsightDesk-section').insertAdjacentHTML('beforeend',
            content
        );
    }

// pageinsightMob
    if ((response.pageInsightMobile !== null ||
        response.problemsListMobile !== null) && (reportURL.indexOf("load-report")>=0) ===true) {
        progress(90);
        content = '';
        document.getElementById("pageinsightMob-section").innerHTML = "";
        document.getElementById("pageinsightMob-section").className = "";

        content += " <div class=\"warn\">\n" +
            "        <h1 class='item-title'>إحصاءات سرعة الصفحة (الموبايل)</h1>\n" +
            "    <i class=\"fa fa-exclamation-triangle big-warn\" aria-hidden=\"true\"></i>\n" +
            "        </div>\n" +
            "        <div class=\"alert alert-info\">\n" +
            "        <i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>\n" +
            "        <strong>معلومه</strong>\n" +
            "        <article>يمكنك دائماً التعديل على محتويات صفحات الموقع سواء كانت صور أو JavaScript أو CSS أو HTML لتحسين تجربة المستخدم في موقعك\n</article>\n" +
            "    </div>";

        content += "     <div class=\"clear padding-bottom\">\n" +
            "        <h2 class='item-name'>السرعة</h2>\n" +
            "    <p>" + response.pageInsightMobile['speed'] + " %</p>\n" +
            "    </div>";

        content += "     <div class=\"clear padding-bottom\">\n" +
            "        <h2 class='item-name'>إحصاءات الصفحة</h2>\n" +
            "    </div>";

        content +=
            "    <table id='link-table'>\n" +
            "    <thead>\n" +
            "    <tr class='my-row'>\n" +
            "    <th class=\"table-data col1pmDesk\">الإحصاء</th>\n" +
            "        <th class=\"table-data col2pmDesk\">قيمته</th>\n" +
            "    </tr>\n" +
            "    </thead>\n" +
            "    <tbody>";

        for (x in response.pageInsightMobile['pageStats']) {
            switch (x) {
                case "numberResources":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد الموارد</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "numberHosts":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد الخوادم</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "totalRequestBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم الطلب (بايت)</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "numberStaticResources":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد الموارد الثابتة</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "htmlResponseBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم كود HTML الغير مضغوطه (بايب)</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "textResponseBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم النص الغير مضغوط (بايت)</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "overTheWireResponseBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد البايت المضغوطة بإستخدام gZip</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "cssResponseBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم موارد css الغير مضغوطة (بايت)</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "imageResponseBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم الصور (بايت)</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "javascriptResponseBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم الجافاسكريبت الغير مضغوطة (بايت)</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "flashResponseBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم موارد الفلاش (بايت)</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "otherResponseBytes":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم موارد الصفحة المتبقية (بايت)</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "numberJsResources":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد موارد جافاسكريبت</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "numberCssResources":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد موارد Css</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "numberRobotedResources":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد كل الموارد</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "numberTransientFetchFailureResources":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد الموارد التي فشل إرسالها</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "numTotalRoundTrips":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد مرات الإرسال ذهابا وإيابا</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "numRenderBlockingRoundTrips":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">عدد مرات الإرسال لعرض الموارد المحظورة</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "cms":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">نظام إدارة المحتوي</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
                    break;
                default:
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">" + x + "</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.pageInsightDesktop['pageStats'][x] + "</td>\n" +
                        "    </tr>";
            }
        }

        content += " </tbody>" +
            "    </table>" +
            "    <div class=\"clear\"></div>";

        content += "     <div class=\"clear padding-bottom padding-top\">\n" +
            "        <h2 class='item-name'>اقتراحات التحسين</h2>\n" +
            "    </div>";

        content +=
            "    <table id='link-table'>\n" +
            "    <thead>\n" +
            "    <tr class='my-row'>\n" +
            "    <th class=\"table-data col1pmDesk\">الإقتراح</th>\n" +
            "        <th class=\"table-data col2pmDesk\">نسبة التحسين</th>\n" +
            "    </tr>\n" +
            "    </thead>\n" +
            "    <tbody>";

        for (x in response.problemsListMobile) {
            switch (response.problemsListMobile[x]) {
                case "Leverage browser caching":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">تحسين التخزين المؤقت للمتصفح</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.impactsListMobile[x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "Reduce server response time":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">تقليل وقت استجابة الخادم</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.impactsListMobile[x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "Minify CSS":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">تصغير Css</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.impactsListMobile[x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "Eliminate render-blocking JavaScript and CSS in above-the-fold content":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">التخلص من عناصر جافا سكريبت و Css التي تحظر عرض المحتوى في الجزء العلوي</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.impactsListMobile[x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "Optimize images":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">تحسين الصور</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.impactsListMobile[x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "Prioritize visible content":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">تحديد أولوية المحتوى المرئي</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.impactsListMobile[x] + "</td>\n" +
                        "    </tr>";
                    break;
                case "Size tap targets appropriately":
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">حجم أهداف النقر بشكل مناسب</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.impactsListMobile[x] + "</td>\n" +
                        "    </tr>";
                    break;
                default:
                    content += "<tr class='my-row'>" +
                        "    <td class=\"table-data col1pmDesk\">" + response.problemsListMobile[x] + "</td>\n" +
                        "    <td class=\"table-data col2pmDesk\">" + response.impactsListMobile[x] + "</td>\n" +
                        "    </tr>";
            }
        }

        content += " </tbody>" +
            "    </table>" +
            "    <div class=\"clear\"></div>";


        document.getElementById('pageinsightMob-section').insertAdjacentHTML('beforeend',
            content
        );
    }

// Mobile view
    if (response.screenShotSrcMobile !== null && (reportURL.indexOf("load-report")>=0) ===true) {
        content = '';
        document.getElementById("screenMob-section").innerHTML = "";
        document.getElementById("screenMob-section").className = "";

        content += " <div class=\"warn\">\n" +
            "        <h1 class='item-title'>شكل الموقع في الموبايل</h1>\n" +
            "    <i class=\"fa fa-exclamation-triangle big-warn\" aria-hidden=\"true\"></i>\n" +
            "        </div>"
        ;

        content += "     <div class=\"clear mobileView\">" +
            "<img src='" + response.screenShotSrcMobile + "' class='my-img'>" +
            "    </div>";

        document.getElementById('screenMob-section').insertAdjacentHTML('beforeend',
            content
        );
    }

// Desktop view
    if (response.screenShotSrcDesktop !== null && (reportURL.indexOf("load-report")>=0) ===true) {
        progress(100);
        content = '';
        document.getElementById("screen").innerHTML = "";
        document.getElementById("screen").className = "col-xs-3";


        content += " <div>" +
            "                    <p class=\"center computer\">\n" +
            "                       <img src='" + response.screenShotSrcDesktop + "' class='my-img'>" +
            "                    </p>" +
            "                </div>";

        document.getElementById('screen').insertAdjacentHTML('beforeend',
            content
        );
    }

//  finalizing
    if (errorsCount == 0) {
        document.getElementById('overallscore').innerHTML = "<strong>" + errorsCount + "</strong>";
    } else {
        document.getElementById('overallscore').style.color = "#E74B3B";
        document.getElementById('overallscore').innerHTML = "<strong>" + errorsCount + "</strong>";
    }

    document.getElementById('passScore').style.width = ((passedCount / 23) * 100) + "%";
    document.getElementById('errorScore').style.width = ((errorsCount / 23) * 100) + "%";
    document.getElementById('passScore').setAttribute('aria-valuenow', ((passedCount / 23) * 100) + "");
    document.getElementById('errorScore').setAttribute('aria-valuenow', ((errorsCount / 23) * 100) + "");

}

function toggleShow(listName) {
    var list = document.getElementsByClassName(listName);
    var x;
    for (x in list) {
        if (list[x].style.display === "none") {
            list[x].style.display = "list-item";
        } else {
            list[x].style.display = "none";
        }
    }
}

function progress(value) {
    document.getElementById('progress-bar').style.width = value+ "%";
    document.getElementById('progress-bar').innerText = value+ "%";
    document.getElementById('progress-bar').setAttribute('aria-valuenow', value + "");
}