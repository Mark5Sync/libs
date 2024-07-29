<?php

namespace marksync_libs\payments\TinkoffBank;

/**
 * Ставка налога
 */
enum Tax {
    case none; //без НДС
    case vat0; //НДС по ставке 0%
    case vat10; //НДС чека по ставке 10%
    case vat20; //НДС чека по ставке 20%
    case vat110; //НДС чека по расчетной ставке 10/110
    case vat120; //НДС чека по расчетной ставке 20/120
}