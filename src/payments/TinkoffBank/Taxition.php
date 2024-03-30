<?php

namespace marksync_libs\payments\TinkoffBank;

enum Taxition {
    case osn; // общая СН;
    case usn_income; // упрощенная СН;
    case usn_income_outcome; //  упрощенная СН (доходы минус расходы);
    case envd; // единый налог на вмененный доход;
    case esn; // единый сельскохозяйственный налог;
    case patent; //патентная СН;
}