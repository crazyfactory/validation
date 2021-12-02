<?php

namespace CrazyFactory\Validation\Tests\unit;

use CrazyFactory\Validation\LatinCharValidator;

class LatinCharValidatorTest extends \Codeception\Test\Unit
{
    public function testIsValid()
    {
        $this->assertTrue(LatinCharValidator::isValid(''));
        // Allow characters
        // English with some common special characters
        $this->assertTrue(LatinCharValidator::isValid('ABCD/xx6521#$%!@*^^_= ()``..'));
        // Single white space
        $this->assertTrue(LatinCharValidator::isValid(' '));
        // German
        $this->assertTrue(LatinCharValidator::isValid('Öffentlichkeit präsentierten/_= ()``..'));
        // Spain
        $this->assertTrue(LatinCharValidator::isValid('Piercing significa en español “perforar el cuerpo público'));
        // France
        $this->assertTrue(LatinCharValidator::isValid('étirer le lobe, les expanders (également appelés écarteurs'));
        // Croatian
        $this->assertTrue(LatinCharValidator::isValid('Većina će osoba posjetiti stručnjaka za piercing koji će '));
        // Italian
        $this->assertTrue(LatinCharValidator::isValid('Si può inoltre dare un tocco di individualità in più variando'));
        // Netherland
        $this->assertTrue(LatinCharValidator::isValid('Voor het zetten van een piercing ga je doorgaans'));
        // Norwegian
        $this->assertTrue(LatinCharValidator::isValid(' er også svært populære. Implantater, også STØRRELSER'));
        // Polish
        $this->assertTrue(LatinCharValidator::isValid('RÓŻNE RODZAJE PIERCINGU Większość ludzi przekłuwa skórę'));
        // Portugal
        $this->assertTrue(LatinCharValidator::isValid('até anéis para o nariz. Espirais ou circular barbells como piercings no lábio também são'));
        // Finnish
        $this->assertTrue(LatinCharValidator::isValid('KAIKEN MUOTOISIA JA KAIKEN KOKOISIA LÄVISTYKSIÄ Suurin osa ihmisistä luottaa lävistyksen teettämisessä'));
        // Swedish
        $this->assertTrue(LatinCharValidator::isValid('Majoriteten av alla som piercar sig gör det hos en professionell piercingstudio. Men för skickliga piercingfans så finns det många verktyg & tillbehör att tillgå.'));
        // Czech
        $this->assertTrue(LatinCharValidator::isValid('činky jako piercing do rtu nebo spirály. Implantáty, také známé jako kožní kotvy, opravdu časem přilnou'));



        // Not allow characters
        // Thai chars
        $this->assertFalse(LatinCharValidator::isValid('ภาษาไทย'));
        // Chinese chars
        $this->assertFalse(LatinCharValidator::isValid('为'));
        // Japanese chars
        $this->assertFalse(LatinCharValidator::isValid('平仮名'));
        // Greek chars
        $this->assertFalse(LatinCharValidator::isValid('Ελληνικό αλφάβιτο Ellinıkó alfávıto'));
        // Arab chars
        $this->assertFalse(LatinCharValidator::isValid('الْأَبْجَدِيَّة الْعَرَبِيَّة‎'));
        // Russian chars
        $this->assertFalse(LatinCharValidator::isValid('Меня зовут Мандли'));
        // Basic Latin C0 controls
        $c0 = [
            '',
            '',
            '',
            '',
            '',
            '',
            '	',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ];
        foreach ($c0 as $item) {
            $this->assertFalse(LatinCharValidator::isValid('Hello World ' . $item));
        }

        $string = "test3 theguy\nfubar 5\nGelbe Tür!2\n154 5thfdd            test\t\ttab";
        $this->assertTrue(LatinCharValidator::isValid($string));
    }
}
