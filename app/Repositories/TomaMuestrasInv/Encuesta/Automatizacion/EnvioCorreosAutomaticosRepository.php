<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\Automatizacion;

use Dompdf\Dompdf;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;

class EnvioCorreosAutomaticosRepository
{

    public static function getlogo()
    {
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAsoAAACACAYAAAASyk9jAAAAAXNSR0IArs4c6QAAAARnQU1BAACx
                        jwv8YQUAAAAJcEhZcwAALiMAAC4jAXilP3YAALrPSURBVHhe7J0FlCTXdfflMNuxE9sxJabYiSEW
                        2o5tSRZYshh2dqcLGoaZZ5Z3lmeamZm5B5akFUtm/pzYiSlmmRmF77v3VXVvQ3UPLsiqe87/dHfV
                        q1f86le377vvoj80u2XW+1dKa+n1CmPyKsaQ3sYZs0OcMTPHmlIh1phaZI3pB1gzKnOMM6ePs6b0
                        CfppTiVZU9LKWVIzCktSA7qp3ZC6WGFI/sNVs7N/IlYvm2yyySabbLLJJptsF751aAN/qzJm3sXq
                        UsO8Keti9enHWEPmewDGv+fNOaJxLpFOzwnS4TlGNK5FonaUiNJeJEpHkaicpTNygdwlovEukg4/
                        lPUtEaWrQBhr6hnGlv4FY0n9D2NP5hlL4gBrid+5zZl+9ezs7B+JmyGbbLLJJptssskmm2zn19Cz
                        q9Tl387qMsOcPp+Bz29yhuxTGscy6XQdJ2r7IlFZAIQteYKgzJmyBKAZPlFpKhZlrpMFlaoRZ4Py
                        9izhHTkKzRr/AukILhHemSGMLfFzzpF6lLUlj3L21PVtDsffiJsom2yyySabbLLJJpts585Uhtyl
                        nC57gDfkPsbpc7/rcBwnKJVlgfDGAsAwQLEBYLgshONqrQOUWWudbEkqzpEmvCtL1L4i6QgtEc4J
                        y9oTX2McKSfvTt40bD355+JmyyabbLLJJptssskmW3Nry+X+WGUqvIc1pK/lDfmLlcbsK2/xev9K
                        nN3UthkWXs3rC9O8vvgor8//vsNxgmisS0SJYKwHMNZnz8iAAhgG8cYs9SYrLQWispWI2rFIOtzL
                        NPyi03ucdPpOkA7fMaLxLBONF6b7YFoApvnx9xJRexaIylUkvDNHeDvUa8vUgHJFdkEIykpPnmjC
                        i4R3Q1ln8r9A+zlL7K3irsgmm2yyySabbLLJJlut9Xi9f8poMxG1ZelpAWozv+eMmZ+zxtTXWHP6
                        BGtJHmWs6ds7jdkXi4tUTDGfe6/SUHhAYwXAdd5DALIJp4M6UFWQzBvzAMVForEvkU73CRp+gV5k
                        1pj5NWtM/x9nSH+IM6VLrCkV4I1pE2fKHGZN6b2MKTOjMKe3M5bMAc6amWPMKSdjTsZZS+oe2K7P
                        M5bkj1lr+knemRcg2r9IlG7YBgfUbQdwFkG5IkeCcK4UUfkAmkMLAMzx33KedJZ1pj8g7pJssskm
                        m2yyySabbLIJxs/nXsPpCkRtxhAJAFozQm2BqOxFonYv0Y5z6LnlbKlvc460n3NlrxEXrRirTb+P
                        0+dLSlOJepTRm4xeZY1tGQD6BP3OGjI/5vTpBzldysLqMr0Awu9jTcV/Us0+9BdiNWsyDJ+4wx59
                        CePIvUNhSbYzltQsY0/nWWvy/wCSn1L7F4gmgB5kgHWHCM0AytXiPRmiCcN+u9PwPX2adyduF6uX
                        TTbZZJNNNtlkk+35bugpZuezP+h230vjiRGUMSyCN2fE2OAU4ewZonTniAY7yrkyzwJYnmKd8QYv
                        LGPI38Ibi/+tsR1Dz/QTnD77GKtLH+Lms9f3zN/3QrFYxVTh8F9wLtdLmWDwddv80X9TRiJv4YLB
                        /4Dp/4LztxnSr2YMyUtZffbfOWPsDe321CtYa/zv2tpyf0wrkDCcz9tTlwEYT/Cu9AJjS/xE5QVo
                        DwI0Axizzipgdgri3CmiDpWIMpAlvDd1P+9K3iBWJ5tssskmm2yyySbb89k4beEOjXXpHlaX+Rpr
                        yPwGwyLUzgUaG4yxwJhZohzzi/G+mmAJPbCEdSdjjD7wz2I11Dh97KVqc2Ebbyj9qzjpoovI7B9t
                        c4Ze3e6KXtzuj12v8MbaGV+sk/XHexlfeFDhDY0y/sg4E4yMKwKh7WwoNLDF738xq89vZQ3pHQDt
                        Y4w5NcLaMgOMPdmjcCY1nCt2N+uJX8tDnXw0+pqOQOBvxbXVGGuK/5PCllSyjlQa4PjH6kCRoDAE
                        owzKZ4A5SdThIuF9acJ5knnGEX6HWI1ssskmm2yyySabbM9nu3HY+ufsfPxVvDF7FWdI97PmtIO1
                        pD/LWlNPY/yvypuvhDBguEJHdAGh8muMLfJBsYqKbXG7X8m4E++hUOyJDYJGGHdsShGIbWf8sRmF
                        LzrN+qJjCl9oQuGNjCIwswEA5nBsRBENvFszl3ydUo8DkaRBySGFJT0E2zHM2lPDjCsxwrqiYwDK
                        E6wvPsH4w5NsIIIe7hcIa5c21hp/FeNM9AEkP4KgTMMuEPjLsOyKUwEkE02khJ+/5Nyxg22OnJxa
                        TjbZZJNNNtlkk+35apj5greXXiL+rNgWY/YvGWvuUtaWPMo6Ml9VBxaI0purgKU6nAdYTjzBuCI9
                        amf61awz8gGY3gGfo4wnOqnwRLZznphmWyj0asaVfB3ri2xV+EM3AeRewgSTr2sPBC4GSO5U+MLT
                        imCknw3E34Tr5fTZa1hDdoIzpAY5U2qQQVlB9sQggPKgwhEbUrjjowpffBohm3PFXko3eBXW1tb2
                        xypP+lrWGU+zzuTvKsAsgnJZSn+GaGIlfBn4hMIavEpcXDbZZJNNNtlkk02254tt0cbfxJszjyrt
                        hZ+w5vSDrCW9lzFnrsSMGGIRagDNL+ac6SnelXpcHSgATCIsxwAo04QLpAnjjKQZZ7SPdUaHFc74
                        KOuJTjDu6O1tXm8lPllqtDwuVnwpEwi3MYFEJYxDqUvdyeqkQRkAd5hxxUYAxBnGG/kg54i9QVxs
                        zcba45fAfoRYFwCz4EU+A8tuVIKoIwWYnnia8SQOt83m/kxcVDbZZJNNNtlkk022P2RjtIlblNbC
                        tzCHMW/LE7VnifQlHiasOfWhZl5atSX0RoDLx1TBPI3rRaDkAinC+hNPKdxRq8Ie6WIc0W6lP/V2
                        KC4ZDoEd8rZ6Qpe0B6IXi5NqjJtLXcPq0g2gDGBLIbzdGXl7PchvxHh79DLOGcvyHuzYBy8BAMgC
                        KAvi4WVAEyviPj6g8IbfLC4mm2yyySabbLLJJtsfonHG7HbenH9G48C8xinCW/NEA6DMWtNp7AQn
                        FqsxzpF9g8KRvElhT3axzsR9Sl8Gva2E8UQJH0wThSf2Y8YV28P7omc684k2Ozv7J/i5xWj8S/QE
                        M97wDOeNTCn8/itogSrj59P/xmmz45whWwFlhSU5hNksWFf8XWIxaowr+fdKd+SVF11EWsYor8YU
                        juhNnDfxEU2kSEMvqmGZ9cSJJl4EaE5+d5sjKqeSk0022WSTTTbZZHuOWlNo3GL0v5g15aMa5zJR
                        WosAyWmidpYQlJ9mzendYrEaU3iT/8DaUgqFPT7KOBIjjD3Rx9gSnYwz/gCmVUOIZDwxoormiMId
                        fpDTx/5aXJRahzbwtxgqofDG7lb4wizjj40zvtigwh8ZwowXvDd41VUPCSCN1qFd/Ftel+0GmB+p
                        eJQtqUlYJ+04eNXsQ3+CKeM4a+pG1hbvZT3RMajnUrrwBq1tdvbPOG9qhvOnfo7AzMKLgADLMfgO
                        +xjOEpj3jMITnxYXkU022WSTTTbZZJPtQjdGl3uH0rR4QmVa+Agzn+oWJ1eMmUu8jTfnP9HpPk54
                        EwCfMUOHjlbZCt9RmJK3isUqRgHXlniPwpYM8o7crxlr8n743a1wxPpZR7IXs0iwrvgXlcEMBWUu
                        kCRsIP6bLZ7Q28QqLuJisb8GSL4LO/fRTBc0y0VsUFB4kPWFxzh/pAfLiYtQY+fSV7P69DSCssKc
                        nMCBRTD3Mp2nzVzC6VM7GVN6CuEds1+0e6KX0QXXaMxc8u/Z+cy76uGecSUv5dzxRzRR7NCXqoAy
                        ShlIEXW0QGC99kt7Ni8ERDbZZJNNNtlkk022s2DYUY6bz97b432AdDpO0iGleV3y3eLsi3hjpk1p
                        Lvygw7lMAZk35Uin5zjhLNmP4KAeYrGK8fb0vzK2tJqzpu7HXMpKV4Eo3QUCoHwKPcqsMznA2GKd
                        jCt2mPXGf8/6EoTxxog6kScAwBaMIcZ4XsYb5WH6OE0TVwHkM6CMHmU2FH+fuNqKcfp7/5ozJFne
                        lNwBEN+FQCvOogOlwD7cTT3N9tiUwh1mqz3SazG1tvBG1pDdxekySqUu/XpxMjX0LvPe1BEEZVUI
                        PednYJnzJ4kmUcJ9ztZDvmyyySabbLLJJptsF5AJntHsD1SmBcLrC0RlLhF+PkNHmeMM2QNKc5Go
                        bQuE06eJylokGucS4c3ZAHqNaQWiqcwLL2KsifcrzMndjDX9X8KgIxnCWpNE5SnCZ+IJ1h7fjYN/
                        ICxzzphG4Y4+yocyFJS5UJIAIP+Y80T6EY7bMSxCyKXcCMr+8AgbiHaImTEawkXa5nMvZE2pm7eZ
                        03S0vhoj5AX80ehLlI7UW3BAE3Hqmo3VZt/E6bPjvC4zxhrSo4wueV2Pd/mvxNnUFPbw3Xwg+X3q
                        Ra6GZV+caJIUlu+pzu4hm2yyySabbLLJJtsFZCpD4c0Ayk8qDUWiNALcajO/YHXpD7D6bLTDcZwg
                        KCMka+yLRGkp/p7RpybFRSvGmJKvU1gy7Yw5ZeGsme8iJLPWNChFVG4KzD9l7AknjVEWcxoz7kSn
                        whXVM974MyACAEzYIO3g52Lcsc4KJEuAshij3NMejGxVORwvFzfjnBozV3gd7Tioyw4qjekh3pia
                        VFqy3DZDLXwzDt87WG/ic5p46Qwsw4sBg7CMnmV/7B4cQlssLptssskmm2yyySbbhWKMNvN+Tpcn
                        vKFAeH2esNrMr1l95psa+zLhDDlQlnS6AJgtha8jQIuLVYwxJC9ljKlu1pxOACT/VuksENaSIpwt
                        TSGZsaa+orDH9zGOhJqGXZRBGeOUMbexO/otPpgCcIwSPpIhCm/kGOuNdrQCZSH0IjyCn3w02jDg
                        ybkwTl98Ka/NDPCGzDBNRyekpBtXGJNDvDVVk76u3Z96GedJ3EthGV4KKCiL0iTgGPmip260WmVY
                        lk022WSTTTbZZLuQjJnL367UF2nYBafLwWeOhl9w+izhjXmA5BOEN+UfVGiTbxQXoaaaDf8Fa85f
                        zQAcspb0A7wNlrUBaAMk8xib7MwTzpp8lLUCDGOmCwTkshCUQTT8whX9kDKcEUA5nEJQ/izjifSw
                        7uhANShjhz7UGVCOjCsC4XYcHVDcpHNimFYOQyzIRRe9gNWmFHCctrOG5CinTw7RTBvm1AhjSY23
                        m1LXVHfY4/T6vwZAznQALGPoRRmUGW+UaFIUlhcAlv9cLC6bbLLJJptssskm2/k2xZHMHdWgzOmy
                        FJJVlgWiti0RpbHgQCgWi1PDNGwYAwyQfIA1pr6ochaxcx9hzWmidAAg2zJPsNZUGiC5C2OSayAZ
                        xDrjAwjKrCveAaCc5coeZQRlX/ibCk+svxqUMeMFG4xvZQKxNoUvOqHwhUDhab7JwCNnyxDKOWOm
                        nbGm+dsCgb9VGJb/gdVmb4NpSt6QGuaMySEhd3N6iKals6Zvx+G8xcUv6gFwZr3xsCaOmS+ETowI
                        yow/RjTJImn3RP1iUdlkk0022WSTTTbZzrdJgbLGtoyxyb9k9Nk+sVjFMHMEb07fxRrTDt6c+YHK
                        UaSAjFI5S4SzZn7EWtMmxpZQK6zJfsZaDciY8SLRzbqTvUL4RaxT4Y56uQBAoy9GuGASoDHyIxxU
                        ROGNDQFIjgM0b0dABkj9M8yDzPrC72L80W0qf/g9UkNbn23j9Ym7WFNyB+7fFlvstTgNXyTUpuw1
                        vDE5DS8QwwojgDJ6l22ZyXZHautttR0fX6DwxWIYn8xSzzKAMrwksIE4USXymE96n1hONtlkk002
                        2WSTTbbzaYr5zA28DuOTBVBWmkqENxa+sE2bbki9hpkteF2aYY2ZIm/OPqGyFwhrSlNvMkIyY0l/
                        gbGmdiosGQ0F5LIEUO5T2GMaxhYPwfdTChdAtADKVupdRVAOASj7Ij/Ezny8N9YGIHkn649f3TZf
                        mxmCkI2PprdWQyjnDfmLAYYHGGNqhLXGxxhHbJx1x2mKvDaH42+UpuxWzpzup5CMsqYG4WVhQuGI
                        sdX7gCEWjC9eoPHJIiijuGCCetW3eULbxKKyySabbLLJJptssp0vw8FGuPns0zTrBYjXZZ9m5jJX
                        irMrNuDI/Q1rSHVwxsxHcGQ+pSVPOJMwhDXGJjPm1P0sQKTCmulCQKwF5VgP40h0K+zJotKdI/D9
                        x6wnNYwd+hhXzEI9q4EY4WMpogiGv9Hu978M8ymLq74gDLeHn8+qWEN6gjVnenG/FM74aLsn2rfF
                        n30xlplFj7c1/nfb7Ol/VZiT/awV9hHL2QVYrk6ph99ZX+xhdaJQAWWUMgIvHqH4T9tdgXMaViKb
                        bH+Ihi/3O1yP/T1+Sql/7vjfz+b++8/E4qszeFEflaiLajb8oh7D8j/0zNamipRNtuer9c8l/77L
                        UPrXLsPCpb3zpStQnbr827v02ddiGKdYTLbnuOEYFhpT4XXd2swl5fPcayz+R6954V/qB2Z7zpkY
                        Z/sTpbFEM18oDYVnmfk0HfK5bD3eT/0pq0tOcMbs19X2BWF0PlOGoEeZt2R/C1AYY4yJTgEgBU9q
                        BZItiU7Glhhn7amPKz15ovICGNqTP1C4kl28Pfluxh3u5IJxwgajFVBmkmcGCbmQjJ2Pv4rRF/6Z
                        N6Uuw30CyB+kIwd6wteKRai1OXIv52zpIZTwogCyJSa32aLbyqMEom1xR14JLwn/o4rDy0MVLOPg
                        Kwpf5HPsBZAJo9tU+sCQ41Rvt65YI7gBegdsx3s7zNk3iUWbWo9l+TW9xgVYZqGhHqyjR5dvA/po
                        +i9Bl7H4LqltWK9oXfr8O8Xq12wdcA10mxff2a0vXi6txXd2zeffIhZft3UeSb2sS5fvhoamYR96
                        zcu93cYCo5p9qKb/wGqta774KjyHUudkI6Ln01hqm52tHcin11i6Yshxr+QyeD569QtXi0WbGja2
                        PfqiRvp4LPTiscJjJhan1q3Ptfdbln/QbSh+p1tfaBBs73e69PkTa3kx79bldUP2U5L19ZmXvtNj
                        KH2lx1B4M5ZFB0OXrqik50tqm/WFzn7X8U1r7/DahGN0uNe4eKTHWDzcSv3m5SNwvY6rws2voQ59
                        8a0r3Xv0nBsyd4iLtLRxY/Yve4x5rv54lNuTXv1iwyBWPfrClc2vnXt7u+YWLhWLNrVuXfr1WH83
                        rKexnlzvkPPkAJynO8Xi67Y+ffGl3frSvtUcf1SvvgTnoLCv11Ccwm2Btu7OPkP+YjxOYpVrsl5T
                        4T2b21be29urK7xHrH5VpppdeBHcU1t7zUsOuL4/CfcD3BOFn8N1+TvY19+jegzFX8Pvn4C+1W0o
                        fAr2Pw7TJ/Fcr9RBH//dxXNFz6fENq9V9NozY12lmoHDVmsd2tQreq2L/473vJRwHra3YvE12aB2
                        8RXdxtJBvE6krp96wbV3BI7hHjjmE12GQk+XrnQ7XJNvbZvNrc0ZsApDJwMcuzt7TYsG2M9HoY39
                        JpzXn0Cb8tvyeQb9Bqb9GOfB94/0mBad2OYNwouTWI2kdesK1zW7jnF6lyG34j2P92Kz52dZYtGV
                        7Sp4oAEof0xtOUZDLzqdJ9GrvFucTY3TpWZ5Y/ZXaluJjs6HUjsWCGdOf48xpXSMOa1WlEMORFBm
                        LXEcgU+tsCQPsfb0N+igI44UgHIeQflx3i6kdWN9kS18JEVBWRlPIyj/74We/YG35F5TBmWFNz7K
                        +iO9GHohzr5IaU2/njWnJyovDGKMNuNITLKu+G0Yay0WvWirJ34JG4j/nI+kz8CyP0o06SJp94a9
                        YrHzZgBj909FPkxG3PfVaNRzP5kMP0Y6Ddl+sWhTw0ZtzPsgGfU+0FDPRPBRAjf2t2ZnSdN4c2h0
                        XVPRjzQsu17h/sBN6xCrX5OhdwSW/TzA1xPQAPxOUsbSE32mxZ8jMIuLrcugsXsvNApkzPdgwz6M
                        Bx4h0Dj9EhsDsfiaDLbtZjyHUudkI8LzCQ++7/bMems8qvBiYpuJfVRyGTy30JAWxaJNTW1IvxqO
                        KxyPhxrqwGOEx6pLm68JGRu2xv8OwPa/cD/7rccaNGg/QQZAnfpCw1D8UtZly74WzvEvhpz3SNY3
                        7n8Iry2fWPyiIf3Sa+H3U+P+hyW3GR72pNOSf7tYfMOGLxzDsG14bodd97YU3VZd4QdMC1Dv0Oe3
                        C/f//Q3bXxaejz7TAulfxX4M6HIvh+vjd/XHQ2hPPkS6tcVxsWjF4DpPN7t2ZqIfJd3zpXmxqKTh
                        iwBAxIcn4dpsrOM0PQ64foBUpbjIug1fwAftJ1d1/KuF2zHsOg3HcJn0Gkq/gWP01T7Tkq/bVLhO
                        rHpVBuAZlmqv1ys8vnBNBcXqWxq+yPaaFmbg5fureAxwvwZtJ4R7w7JE4CUStChqie7rAMzDMkOO
                        e+j9APfKd/GfGbFKScOXcGgv/ncy+JjkNq9VeK4mAo8SgL41n38EYOFcLfwS2oWfS6nXtPQL2K+v
                        95sKrxMXW7XB8/f9QvuP14f0tSOlmuvJWMJt+yIcd1uXqbZ9XI/1agtv7NGX9PCc+8aA9ThdH21H
                        6Xlebn6eocyw8156rqEd/xlcq8f4oyXJ9L4A2yeaXccz8LyAdl4rFm1q+ILX7PlJ5Tr9rFh0dcbM
                        ZT2dUCGCMnbk43TZ+8VZF7GGjEllKRIUAjJvzhGVvURYc/ZzLHZeM6c6KjG5ZVC2pPrarfEO1pr0
                        cbb0r3AIa9aWJJw9RTojx+F7Ylms/iKFJzqtjGUJE4gSVTJDmGDoI+KsC9awQeDsSQ3jTMxgh0Mm
                        GPngcBXctzlyf8OYE/iSMFoDykJavEnOHrv+InJmRMF2d0TBh1PPCp0aBVBmg3HCRzFdXuBusdh5
                        MXhIlfBigxutRnDz0Qu/05jTiEWbGlz0NyPgQCPaUA+CAoJna1Au6BFM6pddr+j+6Isr3mhS1qMr
                        teGNLjQI5cagUfTBq8vbxcXWZehJh2P3JNZXvw/48IHPb+Df/GLxNVm3rvQBPIdS52QjoufTUPzv
                        eo8YAMQcNqhSy4jnNiIWbWpKY/aVUO7n2PhWL4/CY4THqkOXrQy/XzZY9wf78IHRZF+HnADY+vx9
                        YvGWBmA5j429VD340IB9/86A43hlEKQB/PcBYBSvl/ry4jb/Fh5eG/73oWz4cgV1P4P3W/366oUP
                        L1j/l1uBSac+PyLc/6WG5auFxwTu0xWz9lCPK7xI1R8PoT05ieDe8OIN7YO/2bWD6+3Wllp2gO7U
                        5eZxeVxH/fJ4TeD+deoyM2LxDVmPKX8ZHNOnV3P8pQSQCdfFEr2WcJvxOPWaFgt4HYmraGlQh12q
                        vV6v8Pj26ks2sfqm1nk0+wY4lo8BfNA2QOpYr6RB8VmwZdzY0psugvLHELCl6lmrcFvxeMOzbs19
                        g3oM+UHcZzxP+DIgrWX6POgzFhoGa1vJEGzpNbCO44mqXE9wbBGc4fvT3YZSdD0Olra23B/3GBen
                        4Tz/hJ5nOGbr2i5Yht7r0E71mhcaR08Gg3so0+w6RkdAly43KxZtavjSis8Eqecnlb6wZlBm1HBC
                        ccARHJ2P1WV+ptZnLmd1WW+H4xjAcZ5whjQOOkJjk1lj+rTClBwVszuMs6bMcAWUbaluhQ1DMJLH
                        cQhrpTNHh7HmXTmi9gFg21NhzEUsrvoi1hvzqZMFAOUIgDICczgrzrqgrd2eegXjSFzJBuJvqobe
                        sgEo38VaM2M1oAxSOGJDrDM60e6J1Xgb270RIz0O/hgFZZQyBi8Ogci32wOBV4jFzrnJoFxr3br8
                        AoKyVL3VEoAx/43OWSF+fT0mg3KtrReU0eClZaHZ+gFEcPlnALiuEotLGnpDoXH9vnjsawXHEq+r
                        LnhwisWpPV9AGYGg21j8dd8KoVjnGpThfv0AXC9PSV0zKHzgw0tSUiy+YdsoKNcLr81R931wfBa/
                        2DsnDRXVBsucc1DuN6Rf3WMsfmnYfZreB1L1rEa43dBOnBKrbWoXCihjiAhcOw+v5njTa1uf/zj+
                        gy8uvirbKCjXC9ucEXTiGAqf4O3S3lwp0xzJ/iMc80W8D7HdkKp7LaJOBX3hSz3zuZpEDWWDe+jC
                        A2X2cPyf2PnMT1Tw0KR5lHWZZ0G/wFzKvBFH58sQtbVEeFPu9wDMEczuoDAmb1KYkzcw5vRdjDnb
                        TYHZnOqAadOMOfk5lauAQ1fTAUhUHljWlfs9Y41NiasUjJAXMN7oA5gWDUFZnc4TRTC6X5z7nDV+
                        Pvpv2JFPUR2jXBbmj3ZGhxXOyCi8MFT+isG/Bxlf5CPqOBwLEZRRmlSBtHtDIbHYObcLApR1RQPe
                        oBTsNkF4o3Xrijqx+lWbZq7wOtjmXzR76FYL1zMADTnG6omLr9lkUK415QZAGTsPwf7+pg+Arn5Z
                        FL0m9PmSWFzS4F7YgeWklqcPeUPhk/U55881KHcbS1cNojcStrPpAwKE2zPquQ/vg+8wc81DL1YL
                        yih6j+oLLaHqXIKysK4iDQOQXhbOpbH0iWYP6/XYSqBM2wW4dxEU8LMfrmXhHmx9fIVzlV9eKX4X
                        zr8D94ve25sgfJHoMSw0/WcMM1DhfYN/ZUttd1l4PGiIBWwbnkv8xOcH3X9YD5bBaV2GYkysuqkh
                        KEP5jw/Bea3f3vUIw4Zw27A/g7iKVVmXeeEdvQZon1fxUoTnGPTUWuO9VwJl9BhXX0/YNq7uerof
                        77VVjduA9xHU91E8x822oyI8prB+3ObyduF3+vyvWlZ4cSg81ux6hnvowgNlNFabjXY6TgqgrM8S
                        palIP3EYa41jCYey/j6nT4102BdfUT2IBgbWY4cVTp95K8DyPGfLfkflKhLWliIAi0Tjh2Xt2W9y
                        1tSN4iIVw+wWCm/k+5gSrRx6oQiEz2uowUaNMSVfB8ehj47QVx+jLIIyxja3u6JjrDfewcbjlQ57
                        7c7I2wGOf02PhwjKbChOuHD8WcYbXFOs2mbZheFRLlrG/A+JjcHGhTFLsF8msfpVW5ehNNEMlKSE
                        DT/s26K4+JrtbIJyr3bhJnxgoRcIQw/O6B4qofEv1KzzjApwHI/RBqt22VMEzxM87L4pEaN8XkEZ
                        DaDP3GwbcHm4Pn/fZZXuGIZeV6j/a3i9NiyLDwbz0rOd2sJNYvGKnWtQ7jDkL4Zr7tPwAP00fP5Y
                        6p4TH1jf6LcsfbpHX1xslXmgNSjXThP38We9c+mmns9zCcrdulyq2XL4Nz+s80cafbah8+BGrBUo
                        i8f9CbgXvgYP6S/Bcfgq7NtPEXbwGEv+UyEKrzH0LneuAFqwbi+NfZdo99YjjCXv0Zc8YvUN1qXP
                        XoP3YzNYxH3GfYP9fBL2+bOwz8fhM0c/DYVP4P7jtYDnSYzvXzHMg3qU9YXPIexJbfNahZCMEIid
                        o8VVrMrgWEObhm2X1L3RKCwL17dVXHxV1gqUxWnYQfIrcE19GdsnuJ9/jvc8vZ4k2pyy8B8g2O7f
                        wjmgnY6b2ezsQ3/RrS/ds9KLEG4L3r/0pdQI0/TFH8JL6pfxOod1fBu27cnyM6PfAp/0viw0dUxA
                        +QsDlHl4oFQDLz+fey9mveANeQGQqXJEacZpuY+y8/F3iUUljTWnFLwt/ysKyZYU9SZ3BJZxlL6H
                        FNpQzfDXZeNcoWu4UJKwgRjAYIIwwcivtkX9/ybOfk4YvlFjj3k4li/mdcl3s5bMgMKUHqVhKC1A
                        mcKyJzrZ7onfLFZFDYB4HLNe4DERYFkISVH4w59sm53d9J6rKxlezFIXrHBjnBtQ7pzPXtFvWurB
                        3rKbIawLtulysfpVGab+69LlPyHlncJjIdWQCd6S4i+7revrTX1WPcra4iW9htKpXsPCKTj+FcH5
                        Pgn1noT1/qjZww+nQ9kvduuKy9XLoqBxvqfLUPDM1vWyvhBAWeXIvRy28XF8ONYvj6LQpc+HxeI1
                        Bg/2frwP4Hw2Lgf71a3L58WiNXauQRkdF5iajmaX0BfD9fcuXqf4wMLe4Nj+ixkvmmacaQHKz8Kx
                        fLZumnAMdYWmnevOFSh3anNd2D5JtTkICX2W5acwI4BYfNOsFSgjkNG/vI9GX4LpBXHwLvWh9Kth
                        368AGN3TY1rALCwNy5WFIV+YUUNclaT1mEvvXm1b2W0odUhNr1a/damnD9ohsfoG69IVnM3ODZ5T
                        6uGEexu9r/UpE4etJ/9cbVh4dZehdAtAqmPIfvJbcK4PirObGr3G9Qu39hoXu6W2ea2CFxVQqRtT
                        m4mrWNEGZnN/A9v6v1LhH7jfUiEoeN/BMt/srwo9XclagTJ61OFaO4HZJ7CTOV5PPfO51+DLFLwk
                        zsO1/1PhOSHl8CiHihV6xFVJGrTxh7BjYKuQGlwH/nsK2/ixbsPCDDobeg9nX4nbhdc53vOYHrDH
                        vLAN6gtAXd+dwo67hkLTf8phv84/KLfPp97CajNfwrQm4iRqjDZb6oAbtQzKassiYXTZjzJwEsQi
                        DYZpR1hzWqt0FIkSByAxJwlvzxEEZs6RdVanQ6s3hTd6CEMNEAopDAbCn5sl5360vfUYptXDfNOc
                        NsNyxqSSN6a6ORqvnToTr70CKCvcwuiD7b5U5UGJf0UovOFH1clyCEYEjk+UqFJZ0u4LN4yUeLbt
                        QgDlC8G6Dfn/7DUtPo1enZp9wAYEHoxUUo2ZE/+SL9aGHK3SziYor2RwTu5t9lIgTK+NxV3JLgRQ
                        RuvU5seF9TWeK/Fv4F/Wx9kidOI1KvVQpJ4ZU+nXyiawe65Budqgbm8zUO7R5TmxWEuTBGXhOn8C
                        jsn30BtamQ5CbxGs94cd2kXJfhXnApQxxRy0NT+h+1lXHtdDAUFf2CMW31RrCcqwf1364mNi0QbD
                        lJK9ptK38BjWL4ui50FfyInFz7shsMK5+Tg+B6S2l+6vrpAWi69oGAKKmW3Enxe0wXm4tRnA1t8T
                        Z6bDNY5tiHb1sdAtQRmuB7jWMmLRBsO2EO7VnzYLN8Pl4cXfKBZvsG5j9m19poXfSLVdZeE57jUt
                        /RBfNlabgg77evTZjh3o1pUa7vWy4X4J7U7jOs8ZKLO6bKjbex9h5tI1b9S8NnsVbyg8rTQWKChj
                        +IXSXPw+p2sMm0DDvMKcOXtC4z1GeGtOHMYalnHkn2AsqYY0P9VGR6fzRP+7u3iSdlrryJUAlCNr
                        +lvifBkDb56cLjvIazOTvC4zxhrSoxiWAqBcyf6hMCaH8BgoLPHRZqDMeBCWYb4n1sO4XFUdHEOX
                        w8vDE+htR1DG+G2aOs8X/sYWo3/dncPWYzIoC4axl/hQrt9++pDQl5ZgH05LgZT4sPjEevJYnldQ
                        NqwEysXnJChjxho4V5+T2jcUbiPsu1ksTq1Lm2Opd1LiYUXLt/Cgnl9QLvjr713cB8GzlVeJxVpa
                        M1DuNZTg5bDwcVjHb2uPi9gHQJ+X7GtytkEZvZTQZj0sXlMNwphbWP9Z6zC+ClD+MBRr6sHv1ud2
                        NgMEnA7H9YRY9LybeC99tdkLCYa3dBnyCrH4H5R1G4pJvM7r91t8npXgGviM1HHBfwXgGlgQq1nR
                        VgRlQ0Hyn6yy9WoLtlbXU4+u0LTd7dEXg5gpQ2pZlNAmLnwT/50UF1mbtRhhGY7f+QVlzpj5D96Y
                        /12X5x7C6dKV/IjoyeTnMzew85ljtBOfIYed+ojKukA4Y+5JzpgdgWKVHWP0iSuVtvz/dniOASBj
                        p70M0biXCGvN/FhhSZpxkBKxqKRtc4ZeDaC8wPjiLgDkUS6WvINzxdaVE/Zcm8KQ/Ad4qeiDl4kR
                        BGbOkBIkQjJmAeEsGQ0ch/dimjjWnpxg7fExhR2guA6UBYUnGW+kZpAXhS9iVacwC4YAykwwQtQp
                        9DKHNyWN0WpNBmW41jF3siFPc0bWbr9wDLp02Tt79DmNVMOJ+wyNybNQ9r1idau28+xRPr0CKA+L
                        RVdlFwooo2Febzx+UtejAHCln/RYcq/BshhWBdv+0SFH47Gg6awMxa+3Ogd/kKAMovetNh+G7/9P
                        vBar5tHQjsc5gGKxmoqdbVDu0mYP433YDCwA8j+Lf1GLxTfdNgzKusJ1LcGoSYjP+TB29uTf9ejz
                        35YCQrxecHvhOjCIxf9grGs+/io4xz+Ruob7rcvPAoBdCS8IB6SeB/ivVbeh9IvVDm6yUVDGf46E
                        9lp6+S5DSbKvTr9h4dXCPkqdW2E/oB3+5Wra2/UYrPv8gjKrTYU7nSeIylTCjns/UulyNOcnq8/+
                        u3IuO6rS5npYbeZjait24BMyXigtRaKxLxLOlD3GmDNX8qZsH2/O/FbjWiSsKUU4a45oPMuEs2SX
                        GGvy0nZH/i09Pesfghpj53q8y3+F3gFx0gVnHJwE9ChLgTJoXGFM0k6JuC/t9tRlAMiMwhZTKlzJ
                        /npQVnhjQ6wvOrbNE6ncPG3h8MtZf/S7mEuZgjKIj6cRnL/V6T93XuUVQdm08gO3W1/64HMZlDFz
                        BW5nfWOFDRg0VD/GOCwcjhUao99KQRz1Oq5jgJPnFSjri5KxwdXGmor/BOU3DMpoXbrCyWZex2Hs
                        dGMoHqLltPlb8GFR/3cqPQ4Az13GQietsIn9oYIyHjt44FsBhI7WAwGug4Yc6XINL/VnE5Q7jIX3
                        QzsD90vj9SHevz/rNWb+g1Z6lmyjoNxnWLgBzw8ej/rlh2kYV6FmMLDzaRjfDvv6v3hs67cVhccA
                        /7rH0RAv9H8M12K9+uLAIN4Tdf0V6AuivvB12p9Fm38f3t9Szzx6v+gL02J1LW2joAzPXhW2Uw2g
                        DNs+aMcQpKxk+4WjZwrOgcb1onDdXYbiAbH4phtcVy1BuVubbRmrjwZ14Ei5awdlVpt9E2vI/bqc
                        0aLDcZzw+jRdITefvZ6CH4AyfB8CcP4MDj7Cm4QcyrwxSzTOJcIa0s9iLmWVDeowpRGOCW8r/Iq3
                        5HbQlazC2uZzL1TYkm9mLfFrGUdCDTrM2uMZ1hl/DL5/gXHFvwLfv8q64l9mXbHPA1Q+DEpxnthh
                        3hNXwfT38VFhZL/zZbcAyHPzGQ2GXjSAsjE1uc2U/oBYlBp6plThhRcxbthfV2yEykMlALM3Mg7A
                        3I43mbjIRQpfeFqdzFVAmQlGiToFv4Nh9O6fE1sJlLvMuRVHM+rRFW98LoMyQIVk7mQ6TZ8viMXw
                        gf4odrCoLyfu4zebjULUzJ5PoAzQtWIKxHZL6mVQflNAGfbjCoDfJyShCkHSWPjW8JHsP8L1vyh9
                        7tFbVvjwSkNf/8GCMu1Yls9glg2o83f1x5Fe87rC/6nqcjSfFVDWFaewoxiU+xI+/OvL4Lb1W5ef
                        WWv6r/XYRkG5y1BwSrW3tP00lp7tmm/ese58GLYTUv+2CCqIxx7aKmPxw3BcxvstS5s2CuX5MBx0
                        o9uQf0TqHFGA0+XpaLrCcPv5L+G/TvXl6HWuL3yy+lnfzDbsUYb5Us8krLPbUPxN19G05FDScK68
                        zRwJdHv0xR/1GrOvFItvusH6W4Jypy67Vyza1Hq09F5cByjPZw0dzhOVznoqyyJ8Zr6L4MofzdzE
                        zWXHaeytLtut1GeHOH3uBIKy2rZAPcvCyHx5zKcMkAy/AZSVtgJRGFNfwyGs202prYwpfTtA4/Ws
                        Nf0B1pK6k7EmeMaWmmQsCTN8L4A+ydqTX2dtiZ9zzjTRhBao1IEiqEBUAYDwQA4E24efIVh/GFUg
                        mhiqSFhP7BnOF/+Wwhe7j/Ulp1lvfE0ZDDbLeEP6XzltdpzGKCMoG5ND2JkPjsV23ppsGLyAdtTz
                        xDQKR3QH44x1sq5oR7snOky9yv7YkMIXneBcgbeKxS/CuGWFP/J1ZeyMV1kZpyn0vnCLtzb91tmy
                        ZqCMEsC38BW44T7UAw8AKeE8aBS+2OzNdLWgTHsZGws7ey1Lul5DaX496jOWtD2gbl161VkoOo3Z
                        N8Cyv8C/mmq3XXiwdxlyrFgUBzeYqveuoSgE2OClQltaU7ze8wWU8TqCBv8Hra4jKAfXUfGT8PmU
                        2JmsRmsFZbROXc4tvU0lYZt0eczq8av6FzzqKTMvP42pscSqmtofKijjSzKcLzqKKk3DVnfd43pw
                        Obg/aq6TzQblIeoVK26Ha8TS7N7DB36XPn9YrO6s2npBua2t7Y979aUhWO7Jhg7DIEzPBfuwhB3o
                        xEWamsocflG3rrS717T+thLbyR59SYsj7onVShpcH+PNzk1Z5XOL5wfupV93G0uPwEvmRK/lmGQ2
                        rNVa53z63+h2gqT2YVUyLeiwY2erFInV1gHwBet7qv784j9O8IyoSREJ0+1S1yR96TEtPd2hL1wp
                        Fm1q6wVlHN2w2wDXgHnx2fp/w1A0j3LVUPv1BvfTh6Taf5Tg2CgWxaJnxeAeagrKmCoRtv1bKz8v
                        Cp8HPSv1vKCSAmXFbPIf2Pn09zD+uAzKdLhqQ/YTmCQf45P5OTGUAMRqMwP8fPou3pgZ402Fr2Po
                        BXqSEZapRFBm0atszhK1e4lovMtCtgsbALUNQNddIhr/Ms2lrPEDDPtKROUtEqUXYNsN2wCgzDoS
                        Z+RKUnHuREWsR5Q7joBMxfkSRBnKEFUUADoB4BxI/I4NxO9j/RHuXAFk2TDmmzOk+5X61DhvTo0p
                        jMkBxpze1qz3LuvJXNLujm9tc4RfTvMmu6KTCndklPVFhzH8gvUHOezoKBa/iPFGpqgXWQRlNhgl
                        ykSaMKHoXWKRs2qtQBmFNzHeUK2ED2apZVGrBeURy9LLegz5n2GOULxR1yPMGYzqNRSvF6td0eAm
                        m5Zq7BBUKdyZiv8kFkUIeCsAhWT4Ba4f06mJRVdlzxdQFjxPiw3XTYMkOkuWtR5QxtRU8DD5oXgs
                        G9RvxQeUxF+nsB8AdAmxmpb2Bx2jbCh8ActAnVf0wYO/HvDwfMF6/gfz7NPKwDYblPH8AHz+Dzw0
                        n5Q6V3QbdPmFlQbq2CxbDyhD+YF+0+Kn8DqsbzvwuIjpuf6vV1tYFVgCgP0zLPvrMe8G20rXadI3
                        X7hBrFbSOqFdhvP5bdy36u1uJtw/LCtC80/gd6JXn79arG5Nhn1Dym261D6sRmPeBxD6frNa7yiU
                        1Uk9D/B+6NLlv1Z9reNzBvcXz2F9efwnBMo7xaJNba2gjCP/9ejz23uNi/+F21R/T+JLP470CDD5
                        Gcw+IS5WY0InzeKXMeVb9bKCxPZfV1p1BMF6DNbfFJTxeYGOK9yOVmqWBrQiKVBm5zO9Gtsxwutz
                        FJKxs57ahnHIGeoR4+DNET3KvC43XIZlbj49xBvzbZwxNcKbsqd5U+4XGH7R4TpGPck8duIDYBYE
                        0GsGaLaC7CAHQnCKsHaAXyt82uDThvmVQQDISneOqHzFMx7lIEA0epT9eaIMZKmoVzkE24ne5ChA
                        d6xIeD/Ug8DsjRFGFBdMEFUc6ovlACTjn2H8iTWP2b4RU5kXXqScT70Fjutr8SITJ69orDX+d+hN
                        bveEb4b9uonxx8bZQHSC8YTeJha5CENMGH/4O3yVV1mdzhGFP3QcZjf9C2+zbCVQ3qhWC8riA/ab
                        zaBmNcJGAtVtLLxfrLalzT700J/A/n8Kb7r6uoTGsjH1UZe+8JjUX13CA7D0a/UqH3Zozx9Q3rjW
                        A8ponbrmo+1JSQS8n+E/DWIVLe0PFZRpGji4/oatJ+mASbCPxxA8qsuUr5XeqjjuzQZlFKbok4Jk
                        ATAWflj9Mnu2bT2gDPM+iwN71MMQlkfPPdR1v+bI6gdGoS+A+sLjzTpirUa0rcRjqs1fK1bb1Gjn
                        WMuxp1u9yEoJzw/ee9A2PttnWiiupW1Ew/4D5TZdqv7VCLcBruPvreYaGYbnNRzXr+Azq74e3A+Y
                        VzNYCnqp4T77slT4hXgPfntwhXC8tYJyhzbwt/icHPM8ULsMfMfyuN4+48Ji13zxVeIiDYYvDbDM
                        d6WetVinMH1tw32v1VqD8iZJApRfwOoyDyMol73JausigWlfwlhbscxFiqPZd7O69IRSmx2twLI+
                        O6I0ZnpZQ7KLMaQOcMbsHGvMHONMmR+p7EWidgHoepeJ2rNEVM4FonQWQAC7LpAHYbhA1D4oE1ik
                        HmWlJ0/hmbElH2dsiU9yjuRx1h4PM7b4POuITzPORB/rjHMozhlT0k5vrtge1h13cZ5YknFFHqew
                        XAXKAJiE8WHO4RgAM0B2LEO4UCK/xed7rbhrZ91ugwuUtRZfpbIl38zZMv+xxRr/93Z74BUrje3O
                        e6Ovacvl/owJBP4ZQZnxRnYqfEFldewj6wsexeG9y6DMReI41PfvtvmjZ31wluczKNMOGabFZxoa
                        YmgsqAdBYnhquPkkPdAoChLGhe1i0RVNBuXVa72gjA8/OGdflNpXKQ27sMd1ftWdWP6gQRke9OUM
                        ErCP1yHw1N8reFxhOz5T7ph9NkC5mRD0YF+fxJAosaqzbuv0KD9WfZ7wWICeBYBb7tXlb19rx/hz
                        Dcpo3XNZps+8/GM8Tw3t5QrCY4Vec7h+vt0zv/rsQOcalOFZeAfeO/UvZbh+2PZnunWZhtFzewx5
                        J3qPq8vTZfA+xPAlY7Fl3PxaQRk92jDvv6tfWoTraeHJHmMxBfdCTd8pKes4VPhnaBO/L9VmYV2Y
                        lxnqaxiFdDMN7olzD8o0PECXe7KcHxmFHflYXbahB63oGe0UcwQP88bcgNKInuXUGG88E3fLz+de
                        w1my17Om9A7GlIpy5sz98P2zrDn5VcaS/BZjBlmS/8dYU59mren7WGsyCdrH2ZN3c5bYW3n72jvj
                        sa7wu3hf8lt8ICWAsi9OlBEA42iGigIzDvscjBN1GvY1nPi2wh86aycUOxcpzMl3w/G9mzVnejFv
                        MmhSYU1OMJbEJOZNVjiSLLwI3AYvAdcy7sR7GFfyUtDrGkbZIxe9QOEOvZENRD7A+EPbFKEzoxmy
                        gfibmGD0N1wkIcByKErUGQrOZyVpfrWtCpTxJm6luodstdYCytDofBvLCzf+2oVgglpNbCkadqyR
                        auQQUrt0he8M2hu9AQOmpbfA/kqGX1AQMBQ+tdqcys87UIa6V5TUcqD1gjJap6GwrV+8rqTqLkuM
                        y/0yZjkRF13R/rBBufCt6lRrXYbifZLrg4d2p26BDg98NkAZ77VmsERH4TMtPtmxSuDbqG0WKNOX
                        DvPScRzdTCy2akNQRtDBv56xrvWItpWwD91zjfDXzDTAGb2mxWN4bVBPscQxaCXhH4nSd1Y7Ql7n
                        XOZWup0gqX1Yjei9UBdC18zwH0QpJ4j4DPsiDkwkFq0YvkBi+AOuq3452iFWlzsmFpW0zQJluJ6e
                        7jEupFoNAFe2jkOJlqAsTC/cIRY/Kwb3xIqgTI/JSpJYrqJ6UGa12f0d0MhzOgGSxawXv8JwC7FI
                        jcGD/G9wiGtWm+uiA2kYUyOsPrNihzkMO8Acw22O3MvbdLmXb7EG/1FpTb+esSWva3eHru8IaCsB
                        8+xs/O9Ye+YSWGZVuZM5d2yI9yV+qwxmCOuOEj6QJOp4gbR7ogXGEx5ReKKfxtALPoop1MShnxMZ
                        gOX4Exi7LFazKYZQx1ty723HUfiMqUnWnBrD3MnCSHyoBBUA8jDrTI4ytsQ4QLIgV3SSccTwk2m3
                        pyRHr8LRCdscjkqsE5rCH16qxCoHcVhreDEIhD61Uq/7jdpKoIw3DT4I8caUEs5r5dlYLSh3Hkm9
                        DBqF72Fjig+/9QjXhQLgXvGhiRkqmuUIFf5ma57ODN7aH8FORvXLlb0fq+nEgfa8ilGGh4nU9VMt
                        4dxJLb8xUMZh6AFg7qsPHagW9U7CNqx2RLuyPb9AuSSk0jPVlqUPdH3+o3icO433vHgzQRmvmy59
                        4WF46P1M6uUUhfX2GotfPRchGJsBymWhlxX2/TP9rrXBMj+//BpY7scIYlLt4GpE20oE7fnsqvtz
                        lI16wQ2lEwBmT2BbiS+Y9V7YZhI6LRYr4zu0sm5t9rZymy61D6uRcG0Wf1I/SnG94dDQcEx/JnUf
                        02tTX9KKRWusPNS1VNuFcba9huIvcXhnsXiDbQYol0U78OkKD2CfNLG4pPF2ePYZil+XjPHF9gPq
                        7jY0H1VvMwzOSUtQxnu9FXegpJ7dNaoGZezEAID8aZoXWQRl0Zu84ugwvDZ/C69LTyAoK9eQKaBs
                        zFz2bTi8M2NJ9bU7o8OsN7qfNacLnCHzcaW98G3GknxcYUm2jEvCmBvGHfNj5gtlIE0hWRXKEj6Y
                        epb1xg9huhYsh534WH+8lwslvs1HUhSUESoxthdg+el2X3ALrXATjDdn382Z0lOMOTUi5k0WVAfK
                        jSPyoWKDCkdkiHViLHKij19l+ARsvwJH58POfAjKbDiGnuVn2FDorGb8aA7KwpslNAIJfLjBtGEp
                        wQU/ABekB290qZsdGxCoY0VQRi9sH4Bjr/nY1fDwXpd69QtUqlV4BGGfmEEbPGDrAOEMaBRvFos2
                        GPbolkophkIPNTRubrFoS3u+gDLuC6zv4/B9sEcnfR2BBrF3OlxLv5PyHm4ElNE6dYX3YM7XZl4w
                        CnH6wr0Ie+Iiq7LnEyhfhfljdXmAvtrrhr5k0HVmb8bnES63WaCM91nXfHGsh8aaN3sRK8NMvtRq
                        NLDNsHXFKOtLH20GBSOe+0inLq8Ti67K6OiEutK7N6Ot7J9LrtmjXTZ4OfkPuFcPgT6DYIMvos3u
                        r7KEZ0r+l3jfiNU0NYzvLW+n1D6sRniMug35/8TwR7FaSes2FuE+wNC52u2lzg/jwtPYfohFGwyu
                        X1uzcDxhevOOcWsFZYyLhnn/i6BYXx4hF+8D2J5Jsbik0XvUUPh/+ILTUAcIz2O3rkjT4J0tg3uo
                        KSgjwGMe/Fbcgbmuuw1FQw/ci01f0qpBWaXLvYPT5Z6iYRcAytiJj2a70LXOf4uNHqfNsZgnmMeR
                        5gzpnpXeumqNvADeXF6Eo5rRTmsu+LQk9d3+e4nGsUQ6AycJY0kviYUlbZs9+q+cN/WIJrZAOK/Q
                        iU8TLRDen/oR44lKBpNzLtdL2UDs89SzjN5XEAImwPLP2wPRi8Vi6zZMCccbUsM8epOrIXkNoFwW
                        zXYBYjyRK1e6Ubf4/S9W+MOP89EkBWU6Ul86R9oDgRVHqNmINQNl4cF2gnQYV85Nig0ZNpBSgLNa
                        UD7XBg/841L7TbdXl/9az3zuhWLRButqEX4hAEPhO6sB3OcLKA8J05umKiobtiNwPUp6DjcKymjQ
                        8D7QrHGm/2QYF1fMGV5vzydQRuvR5dvwHql/sFNvPTzchHzHxS/jNlTPL19XawVlhOMubX47fbjr
                        Cp9pdv7wYYnzpAZB2Uxbn0c5fw96UvGflfplKDgaij/tNS/8i1j8OWcYkgDn5rpuQykJ5+FJSYgT
                        hecJry2p/h/nywRwLH5I6tqi4Vhw3bX6Zxf3He/1+nuievlmOZXXCsroLYbr6FPNXhqF523+21Jh
                        g9UGLw/LzfJjU4+yPv9FHExNLL7pBvdQU1DGtgCujxX7+mC7is8EqecnVTUos9rsNA27wGwXAMpK
                        Uwk78f1E5ZBODVJlL+C12at4fXYawRC9yipzekM3K6vNBDpdsC3GDO0AiDHL4qwGY12R23hP6nHM
                        doGp4ThPgmjiJUwN9+l2V3PgZf1RFRuK/4gLxSugzPjD5UwRn9xiNK7n5L6AM2bfwOpTN2O+ZN4A
                        Lw71kLwOUEaxNI9ydJLxxtpYX/xVW/zZF2uC2X9EMFaFZ2v+IoF9iQgDjgigrEpliCIYeuSiVeTW
                        XK+tBMp/iENY92mzb4K3719JAZkQdlHbu1nKoPF7SBI0ATho42gs0JjNVva8AWXqVTl3Q1g3sy5D
                        8WSzxhm3sdewWMmZvVp7voHysNX65136wieF0cDOlBeu4dLvOuYyV8JyH6//W7d8XcGxWjMol0fm
                        E/4VWJQcRAaF5wDm/75Dn1lV6NN6bF2gbMy+Dfb/W+I93SDqwdPndorFn9OG0AjXgWTmCEEloY01
                        Fi6Y/dXgUMjG0jOYv7d+e4exc6++0LKvEKe/968RLGnoVt3y1CNtWngW6m8YdwFtraCMhh5yKC8Z
                        JoJeZXo/64stn9vwUjvbzAtebkN6dKU2sfimG9xDzUEZtmvTh7AGOD5WiU8GiWEXq0oWjW85nD57
                        DadPjWOuYNYUX3eMF4ZIAKA/prEvU1DGLBmsOSU5AAPriu/gfamnVMEcYV0xwvvTRB0pAiQnk+iZ
                        FovV2PV6/V8DaNpVMdjPcJIwvjDBzm/UA4uwjB7YTJ4ofIFd4iKrMhymU6XP3gzHYZw1JCfoS0Pt
                        cNUbAuXyyHwAzGOMD74Hot2ML9qn8IZ6OV9QqQkG/1HclIsUgXA7Db8ICeEXNPtFIPQrzJghFtl0
                        ez6CMmzPThHeaoTejl7z4jOYDUMs2tQoYDRpaGgDpC9gJ46WfwPLoFxrZxuUYfl7mjXOuI19+gVe
                        LLpqe76BMlqfvsDTawTWVb0M1tNtKOrg2i9h21E9r3xdbQSU0bq02cNDLUIwKMAbi1/CPg/iIptq
                        6wFltK75fDc9JnXHrLKcLv+J1Yzk9lywLkPuUoBOuI+lAQbPNZzzFYcoPlfWbSwaxX+9aiS0Qwu/
                        7TYuVNK5NjN4jpqagSd9MdAXXWLRGlsPKKN1aXN7cBj5+mXKy2HoglhU0jqFf4EbstiURZ09htIX
                        VLOr79i8FoPjce5AeQs0Yqw2+wMV7CwFZX2OdNiPwff0qgOxMTaUM6Y7QUOr8EI3Nezkx2oz31RZ
                        SoQ3AwCb088qqrJooN1ht7+EcyVTmnCR8D4AQmeM5lHmA5knFY54U8DlfLHXssHEA+pkkWa8wM58
                        KhzBzh/+McDl4zRbRDBM+FgSIDPyIz4afY24aEtDeGO1qdvQKw+gPEQBuaxNBmUKy77oMOOPjQif
                        4RHQjMITqDz4le7IKxW+0M+4KO5PhAKzMp4k7cHgpnZWrLbnGyjj9Q7b85n6BzmKNg76wmfLqa5a
                        Gdycb+oxFX+JqXTq66ENrLH4a/Rci8UlTQblWpNBeW0G5/C8gHKPlw4n3RDjiNcsTP807HOm/u/3
                        zQLlSfTeGQqfanYeUVhXl76QExfZVFsvKPfA8xHOiWTuWrHtfAof/GLx57x16/J0QIz6fUXR82Mo
                        rsmhdbaMtZ78OzjuX5Pq2IahCd264oNi0ZaGHmP0HEvFy9L7UScdjrdeUMYRFaGM5POHjjJrLP2i
                        21pq2u9MCJfJ/5fUM6AsEfwLq83itBbDNqLZPbzpoNw+n72e1xcIbxDik4U45cwT2MmOFlilcabk
                        rehVVunC6wdlbeGNAJxPKk0ForQWCGtK/Rzg+c3i7IsYR/gdvDv16Y7IkjAinytONJESxiZ/j3FE
                        bxeLNVi7I3wjF4x/Q50sCLmUAzGiTuNofdHPt/sjb2cCkfdjZz7a+Q3gUpPFtGqhg+LiLY3TZ97K
                        6rITOPAKZ8iegeSzBMrUo1xReJDxR8YZf+iu6g4oCl/4QSVmvIB9Ke+PIhhaMRRgvfZ8A2V46F4F
                        IPaMVIOGN2jvGjwdXfp8Q7qsskQ4bPkwWAUof71VrPRGDM6JDMpVOqug3KLX+0YMAbN+f84FKKN1
                        GQo9dLmqBzze//Bg/yVA6kcQGqrr2yxQRuvWL74T7t/fS0ECCu9t9CzDw3ZMXGTTbL2gjAbLZcR7
                        oUHU62gozYtFLxhDSFrtiIFl65pPvQU9yhTY6vZTuD4xxr245v4AZ8PgfG3BtlbqeUA7kuryg2LR
                        lobgCc+Dz0s5YCrPUomMOusFZTS4nh5s3p7RZUfFopLWayqNijAsLdgmWr95YbFnfnlVzscqewGO
                        INmsczS9F5ps+6aDMjOf29kBNyenE+KT1RY6yMh/X/XQ2v7CAUh+J2tI72qVIg7TwAH83sxapUcQ
                        4ubz/4nAzhvzRGUrEQDLb3X6hUa2BzNWOOKf6owtE9aZIJwnSTqiC/CZemyb0980K4TCE5/gAokn
                        VNEsYbwRwgWTRJ3Mo1c5p/B6K29nAJcZOmAHgKUykSSKUPhrvN3eMpgd/+bidWmG02bH4dgBHJ97
                        UGZ94WGFP9R7ozVOR79Caw9EDmoy8FIggrIymYb9CX2sIS/zJtnzDZTh5vFINQ7CzVZ6Ahqzt4tF
                        VzRYbrBZQ0OhYAXvdGtQphlHvtWlX3otpgTCEdJW1Gz871Z7nKFuGZSrdDZBGRt0jGOUPGd1whej
                        1f4F320suur3RwARhNyVO+GirReUMf0nzJfsfQ/w8RuYd9ZAGQ1AfVa4rhoBA0Xhw7T4W4znFBfZ
                        FNsIKHcZiizGsUpB0aAde/oX/wevE7H4BWEIO92G4jd7zYunMHXiSp0O8d8TODYfkYrXRQn3ROEp
                        zJghLnJeDa7HPF5j9dsp3s8/w/0Xi65o8IKob/Y8wHusW5c/IRat2AZBebxpe2aHZfXFx8pZw6Ss
                        x5t7ITwPv9SsDhRul9h+fw9e5HYDL1ScnxIGcFx8K5TpgTb8w736wqlmzyPYtnMHytx8NiPEJwug
                        3OHA75kVH0j1hpkrMOsFxuiil1WcXLE2XfjlrDE5oDAmp1lrZkxhTt5QP6AIq83epoSDyhtzRG1f
                        QI/y/8yKndC2BLP/CKD8LaUvR5ReAPpQATvv+ZsNB3272fwi1hsPqaJ5gOMUhWRlBHMmp55p90UO
                        1HduY/zh97CR+DNCSjXsBJcmbDjccnx53DalPruF1+XGzhcoK7yRIUUgMrotGq14nNhg5E4hhESM
                        U47iKH2hn7Eez1nJEXohgDI8QIbhDfhj0CBviqCR+Bisc0isvmIaa/Yf4eb5LoJE/XbSY6AvPFy+
                        ZldjncalN8BbdxPPCY7mtEj6W4wS2AqU8fjjAwXmfw1+/y/s15dbqc+4+GUo98UhAGux+pYGdcug
                        XKWzAcoIcXCcERi/Aev+H6nzVi0o/2W4luB7c7jDNhNjJvGFDh6ixXoPFp4/3BbsgIRl+szZN7V6
                        WK4XlNHQYyXESdY95GEban6DytfVZoEy9v6HY/axZmkaoV0T4pXhntjM8KWNgHK/MKLej/EluH5Z
                        ob1YIl3zhRvE4pLWbSxM0vatrs1brwBKsK1smk6sx7R4GZR7BrN24LUG5/H7cN4fguNrgs9+ONdt
                        VNBeQD0pmP8zqXalLDwn0FZ8Gl4KmzoQcrncH/foi0F4CZPc5rUKtulj/dZjH+s2FWoGV+nSZ18L
                        5/IXUu0Ntgd4f4lFV2V43/aYFiT/rRTCIRZ+BddiDWhuBJQ7LAClxtLvpJ4f9HlsKD3ZrS1eIhaX
                        tF5t4aY+y/Iz0u3XGaHXXWw7fwbn+dEuXcEP1+JBuJ934wsCHMcM6DMw/5fYJoz5HoTnabGpowjL
                        N2uLNxWUETwAlL+ghhNQAWV4KwVgbelub2Y4MAhnTLbzxvQ0q4/frHamX43ejW3W9Ou3mdNqHHQD
                        YVFhSQ+JI9P1MabkdZjJAZdn5/NbMVaagrJjkTDG5CdpxWAKb/IfAJS/hh5l3pv+LWuPNn0Ib3EH
                        /533Jz/akSgR1p+gQ1ir43nCBhI/2OYNSPfCJOQFikDooa7SMtHkAMKjMbKaVHGsNn3t+fQoC+EX
                        4cltoVCl89gWv/8NCn/4l5U45XCUsBFQIHxWRp66IEBZl7dPBB+FG/Hkpmgi8AjepBax+op16YpK
                        2ojX5cpECcdgdX+zVVu3Lt8UvgTvQsEjFm2wVqCMwnOAf1PiMVxJuA3Y2PXPl1aVtxvOiQzKVTo7
                        oCwIHzJS56xeeL/hMewyNIel7nl4GMPDCB7Gv4aH6FP16yoLzu/v+82Lv4F9/n898/c1Dd/ZCCjT
                        wUX0eemBC+pUvq42C5TR+g25S3tNi79udeyxXlhnSlxkw7YRUEaDZReadcLC9gKPhVhU0nA+tm9S
                        7d56NBl8DNvKpqkbe40AUuW2Hc4hHmth2VOCYJupxN84yIfUvqHwGqD7qCv2itVL2uzs7J/Atf1f
                        476HxHVtTMMIbl4AN2Nt6AO03VP02oftqt9OIUVa6+Gn643G/eoLn5NqV1HCvhdqRkveCCjjMxW2
                        8UO4j/XL0uWF6+mIWLypYcYVXJdUu1sv3Fbcv/L5rhZOL9eBbQK8pHxZ1WRMA9jucwPKnL74UnY+
                        +2v04iIo84Y84fW5Z5W69IpjfTcz/MuPNWVvBkicYemodOlO/FSY0qP1sMha48MKa3yCtUM5V+IW
                        1pCar3iUAZRZY+pDYrUUlBlH/Ge8N/Ndzh5rOhIQ647cyfkS39fECnQIa4BwokFgDsQ/znhCLeOu
                        232Rt3Dh2JIykXpYEQwqV5N4ntdmbjr/oBwZZwOR22Bz6PZiiEV7IPJlPp4SQFn0kCtCoXW9AK1k
                        FwQowxupCFObIro/+mLDSEqwHaek9rXfTB+0P+9dR3rESqxmXZ0o4S/w5jmVVwLltUh8cD/Vp11s
                        2YGwbLBdMihXCbfxbIHyaoXHHuuB+poOK9xnWngfnmshzrPx4VoW3ou4r3Cev97sYYW2EVBGg/ts
                        +2ru3fJ1tZmgjAYgsVt4IZU+Fngc6Hrnsw3/MK3HNgzKhmKXcH81bi/9p0uf/3YrDziUsze7htcj
                        PL69+lLTPjDd2gLfLFxkrRJHIrx/doXOYQIoFz/WKh/zWoTbLrzMFSpjM+A4ErAtHxXbuhrhiy3M
                        +85K176UwXJHhOuxtk4UPk/heH62OifzRkAZDWBwT8v16eCFYxX5kLt0+QN4LKT+bV2PaDvWYuhw
                        uIfODSjDQ+UKCsh67MCXI0pjkbDazK+2zW0sFzKGVPCWzABjTI3gyHToQW4Fiwpbcoh1xHt5ayqt
                        tOQJZ8wKHmVTChsMajQjhjVpZV2BZg/xFzCuyB4+kH5KFc4KQ1gHU0QNwMx4E1HWaq3E8G6WXQU3
                        I2vIKnDAlfMKysHwCBcIq6vHaAdAXlClsmKccphocnmiCIdN4uxNtecLKHfOp/8N9uk3UhA2TP++
                        LZTEomsyBKUefeknUqBUPoaw/5IAJoNyrcmgvDIoA2C9F8o+IwVq9RJe1Jp7ddA2Csp9+uJLoZxk
                        Nodqla+rzQZlIYtN/rFmsIDCfYHr59f4YBUXW7dtGJR1pdfD8pJ/99NjBO1llyEvmVYVDcqdU1AW
                        wuI21jZjfmI64Iqp9JnVdAo7F6BMwySMC89IPbPwmABkNf0nsJXB/XJFj7EkWS9O6zUvPdNdFY63
                        EijDdrTM3gLX0uVwXJ/qlbgexXCeZ3u0+VX9Gw3P4c5e09KPR1ynaXtbX99aRJfXF3+H4S1i9TUG
                        231uQJmdS92ptiwBKAOcAihDY4ig/NWVxvleyTD1D2tM9lKP8mpgEeVMdLLmVEhpzRHOnBFBOf05
                        sUo68o34tcHuOBp9CetJpDXRIuEDKWEIa4BlAOUnWE90Wiy26YbwDseuD0B5+HyCMuePDAEMD26p
                        yqfMBEM6zAldBmV1BqA5FFoXyK1kcEEt4kOK3sRVwosP/yLsMOc7xKJNrctQugVvduyFXl8PjUnT
                        Fb7QGpTzljHfQ/TBvhmif7MZCjUvFtDgHx33P0z/UqsWPtywEYcbbk1/s1UbPOhPjfth++lf6NX1
                        Hyc4HW7Yh6VGdurQld4ND4RnMGax/ritVSKoPdtzpGVni4rB/t6PD8D6eoTzDtBoLI6IRVdlPfq8
                        Fofjra8PNew+jdsWE4s2NQRlOB6/Quiqr4N2boRjpZ5Pr7tzFjwIHhNCfBr/NpwIPUb6DIsrXuv1
                        RkFZX/gxnuv6bV6r8NhjPZ3zxab/uiEo98J5xphHfLi2EkIXnOevwLOhKSh3Gwqjwv0vvOiWhdcv
                        zPvuarxq6I3Ch2t9HdUqX1c49Ky4WMXg/gg2u3bovakt7heLSlrfXP5iKPsr6mWXqAOBgYK4sfgF
                        zZFspZ1dj+HDGSEXO0vV3+ujngcAckufhmIt/82E4/rAmPcBukx9HTS201A8SS6S/kcUzr8H2zep
                        dm89Gvc9THoNC02H3AfYseA9Q2EErikKIKsSvPTBcULoxBcVuDaS+FIlVtvSEJShjs+OwrmX2ua1
                        Cu8DvD6rB4GC+8KLoR0NZe3CM6FV+FMrw5hcuu3e+xvqxnYN1wnzK21hpzl/NR4jfClouBbgPEPb
                        cr9YVNJmZ//7z6Bd+/yoB9bXcD2dIGP0+VMMi8VXtM750r/BuY7DNf4E3jNYB95DZ87rysK2p3ws
                        Mae2WHWN4QuAFHeg8J+HLl32gFi0qXXNZ97V8vlpLAEo63LDXdDAC/HJOaKBwqw2+4BYx7qtw556
                        BWdMDnH1nuRmsFgGZUvSwVsAcC0ZonIWCGtOfpdxJFr2GGXtoUs4b/ozdAhrT0IYwjqGA48kvsN6
                        wjeLxc6K8XBBVMIuziMoKwRQHlG4Q5UUPIpAaFSTLWe+CBNlEsMwgp9aaRjs9dgF4VHW5nfBDfkt
                        KPf1zRDU9c0eXaEyvj6GFME2Ym7XL8I2/Xe1AO6/CCD/0EY6/AAo3D5gO/l5qO8LDfWbF74AN/Mn
                        Ow419p6WPcq1pjzrHuXCEBynANTjqhfUD9MX1+xxPNce5W5t6Sp8COE9KzwYm4t68fSFb2NnbXHx
                        BtuoRxlNbUi/Gpb5bqtjUL6uNtujXLYubXYa9vmZVjBHPYWGQmQjeWF79dl/79IXvwzw/TUAkMp9
                        DvD7BVg/tD/FpFi0qXWb8qoB64n/g2353+o68Ds89L8MdX262V/WXYb8AWzfsJ3bDA3aTkK72/xF
                        pEdf6oNt/TRcR7+jEEnjfk9Rrx9+4jktC3/jvV6eDs+Dn/cYF5ag/jU9y7EzHyyzAGC5KfsJx/br
                        AO3fRIcO1o9D5UOb/BBcr9+oL9tvPvbNLl3u/p5Z71/RjVmHwfqG4Vh9HdZRUzeqD9YJ5/lD5ZfX
                        blPmEmjvvgYvv1+tXAv4qS98EZ5XsH2lljHraFDvpFC2+D8N15Pl2FdhOx7s0C7+rVh8VYadOOH8
                        WftMC1/AF016buvOb/V5L18PGC+NcA3tya/g+v6oBu4Xscoag209RzHK2ry5AzaoDMrYkY/TZuJi
                        Hes2hTn7boDcCUlQREmAMmtPdsHnHHqTEZR5W5bA7ycUzvj+dk/snVKAxzriCoDjn+KIfHQIa29S
                        GMI6kHp4m/1MFoizZYwuc92FAcqhITYYHqvufNgeDG7FGGUh80WY8PEEZr74P1U43NQztF7r1qVf
                        jxdcl2Hh0mr1gzrns1esNGY8Gnb67NHmL0PV14N14MNFLCppHdrA33Yfjv9T55Gll22GsC5MqSZW
                        jx6KPxJSb3lfOA0NRrVw2zcjoXrbrIOmcKuvH9NojUKj2OP9VINHeRIzGJiKl0gdt7UK68C6VvuP
                        EuZG7YVzI1UXnrPVen/K1guQi2/4UvXh9dU71zqtFBp63bt0C+/ARrq+jvL+4YATYvELwvDa6bcs
                        vb1bn7m8fpvXKrqP+uLl+CAXq2+wftfxv4cyN/fBQx+Ox82tBC+Bt/TqF66W+jejbELoROP9j9vR
                        bcy+DWM5xaItjV5PxpLk9VQWXm9SHl182Wh17cC+rJjxB+/xbm3mEgyNkKoHPVu4T/34V3WL47GS
                        YV5YfKnG/ai+zzE1I44GODB7pt1pZdjHCNsFBJhyHfidPxp9Ce7vbBOnCJbZ7LZyJYjCaxyuk7cC
                        cN3Wayzs7NYV8WXzBJzvR+DzkwBEnwJ9AuDkYQDrEobS9RkX27sM6XU/x/EFjd2s/bQsvUyly728
                        3Dbi+cdjjNPqy3YfLtY8O9ZreC3geuvrx3UOgMrPHLxu8VrCAWnwPJSvB3wuYdktq4gvRsP14Sh6
                        5eXL1xPWi/Wsd9RHvK57dNl39xmW+uFcu+AaWC6fd3ih+xRA+ifxN0DpMbgGfADn22HezfD9zbhv
                        YjUNhmlPpdod1GrveTp0uLb18/Midj5XUJuXK6DcCSTP6jIbimPFA8sbUh2sKXmm8169JECZsSd7
                        WFtyF2tK/UppzRLOmiacPfMsY485Fc7oQLsjsrU8NPVVD83+CeOMHeF96WeVAWEIa6U/Q9ThPMBy
                        3H2Ld/1vcqs1DAVhtVXxyecRlKmC4cltvjOZL1j4zgTCT7MRHEQlTLgYTRH30/bU2RmWVTbZZJNN
                        NtnWaghgCJ7rBTHZnpv2nDnvnDb7mMq0WAHlLudJwsxl9oiz12W8MXkTb0g39yajpEDZmehrt8eH
                        AZT/T2UvEM6SIipPkShs8UXWFe1gnfEJhSvWDsD8FtaVLOKIfLw3RYewRkDm/enfKByRTemVvBpr
                        g7c1pTbXxemzIxcCKLOh6IQiFK3ERG0NBN4KoPwrzKFMQTkaw0FUnsTUcWIR2WSTTTbZZJNNNtma
                        GTeffZzXFwVQ1ueFHMq6zJriCqut3ZJ6Ow5jzRnTQ2sGZQBFhT2p4cypR9XOEgVlpStPGFv8S6w7
                        0su5Yv2MK9LDOGLxjgjAPQ5h7cYhrGls8tcYZ6TpoAyrNRy2mzfkC6BHOH1mCfbDz5uye3lLpo0x
                        J95R/fd6uzb1Cn6+ypt83j3KkXEuEL5D3LyLtoXD/8IEIj8RcimHaR5lJhh6lgvGNtxrWzbZZJNN
                        Ntlkk+0P3nhdgXBawZuMmS/U1kXszLfmXttoGBelNGZ6OWNqpCkkltUElFlHqoOxJPxKW74cekFY
                        e/IJxhY7rHBFuhQAzKwrvoN1Jn6kCuQAktGrnD7VZomudQzxBsO4MVabP93re4Bo7MeIxgFyLhON
                        a5mo3YuEsaR/x1pTn2NtaYfCmrxKqcu/nZvL9Sh1ud4LwqMcDI+xwcjWHCE0OwiOwseEIt/nY2dA
                        GdUeDt9Id1g22WSTTTbZZJNNtuZGIbkKlFU0PVy2af7FZoYB15wheQcNuWgFiWU1AWWMU1ZYY9th
                        2V8o7VnC2lJE5S0ALMcfUDgjGtYdH+CcMQ3jiidUocKTnCtmudFqbTqM5VoMe8ly2ux/d+IQ3vos
                        AeglnDFDOBPAujlNeHuOqNwlovEtEd4J02ypL3OGdBaHr1bOZzQAyv3nE5QVocgoE4oy5U6PGM8N
                        gPxdHMq6DMo0/CJ8xussm2yyySabbLLJJlsTqwFlQ4EOOKI0Zu8UZ6/aVOb0vygN6VEacrEhUEav
                        cryDNSceU7uKFJQ5hFJn6teMIzbLuGOdrDM6wLqi06wrrhJXv2nGzWen1JZF0aO8LHqUl4jSUSCc
                        FbbDkiKsFbcpDdAMx8pRxOmPs6ZUCI5jD6/Ldp83UA6ERtlghCu/OKjM4RcxgdB36kGZCYVupzsr
                        m2yyySabbLLJJltzkwJlXp++S5y9amNMmffw+szkipBYVgtQBgjtZG3JedaSfkYMvSBKXx5gOf5Z
                        xh3tVrhi/e2e+DDjj961xWhcVdqTtZhiPnkFHIttnCEzyxvTCYD/D3Hm9ONKZ4GovYsUkDmHAMzo
                        aUaI5p2wfbbMpzhjdjtm/DgfoAwwPMIEwuotWSEVTI8390IZlGWTTTbZZJNNNtnWaZvlUeb02Wt4
                        fWpTQJl1JgcU9ngXY0l+FLNeIChzziThvVnCOGN51hVVKdzRAcYVnWz3hG9ulWdvs2ybIf1qzpK6
                        nrWmDYwt9QWVJ0/U/hKNo0ZY5mxpovLCb3v6+4wxMafUZzTnA5QV/qCmnBoPc0jCtIbQCxmUZZNN
                        Ntlkk0022VZhnC7fEKPMaTOsOHvVxhry124WKFPZEt2sM76btaV+ybtyhHUkCOdOEc6TfFrhioZZ
                        T5zCcrsnOqn0Rd4ibsamWLspdQ1vy7t4a76D1ccbBrloc+T+BiC+DeD9EfR0K90FwbtsSxElADTr
                        TP2KNSf1FJZXs+/V+70BUK4PvWgPBF6hCEZ+UN2ZT45Rlk022WSTTTbZZFulsfPZH/D6QgWUNdYl
                        wsynO8XZqzZGn7mSMySmNg2UQQpnUsPak2HelSWcC/MlJzDDBeG8iadZTzRN45Wxc587puT0sU0Z
                        aYs1ZgaU1vyvO7zHaaYLzpr9HWtKfRy2521ikYq1teX+mLHBNriS31UHFiko0zARL7x4OJO/4Cyp
                        A5wx3bnivlfv9wZAGbNeKALh9tmHhOTdnM/32vr0cBSUQ6Fb6Q6cJTvU9Wj3kZ6Pxg52Phqo1cON
                        6m6inrXoIUF9K2igiQbr9YCkDoBmG3SfoOEWGl2Hxk4310RZ96xeU2vRKUHTjdpb1vb16ISk9uwA
                        7SrrGPwG4Wcz7VmH9rbQbL0WV9SuZjoAOthMpVVpR/X3w4J2SelokWqH+FmjOZgO2r4u5QVpW0i3
                        FmUFGVAZ8bNOJhTMk5K5mVKr1nRZ1hayl5VcheJUU44Wcq1BnnXIG20uf60m/JH1KwAK1StU0VjV
                        9xpFWmus4XsgMBH1U41JKb5xjSabyRsYTa1FHkGZFso2Ub6VXFTD9SquR47AcKlWgy1lF7S4Di2D
                        jjWTdfU6YW6uU+vQPdIakJSJqu+0KdB/2hQcetAc6r/PcjmFGlab/ZzSWKKgLORRPkGU2vQonbkG
                        UxmSb2axM59+4535ymKd8QHGmeiE7/eqfADzriRhXXGA5SThAynC+OIfZrzhGcYT7VMgLPtj1wM4
                        /3uroVubGYI2Z8p6NM4lorIVCGtMEZWzRGGZNacd5REBpYxxBV/HeVP3a4ILAMoAy44kUfnzBLb7
                        mzg6IWtO9rbc9+r93iAo8+EY8HuOpofbGoi9VeEP/5qLVA04Egw9xcYbveSbaQDAi46xrxDDwGcE
                        DZb16Rrph1po+FPNNVKvTwoaFaST0tgnmmu8ThMfbyrtZL0+JmiqhWbK+mijtguaq9eOjzTXzrI+
                        XKtdjTpa1u4PNdeeej0maG+jjpS1r6xHGzXbRPsfkdThA9V6WNDBFjpU1kO1OtyoQ2UdeUBaR6V0
                        v6C55jqoLeu+WulaSH+6uQyCDhjurZWxhUz3NJdZ0P6KTgmySMhar5OCbM01ay/rRKMc9TouyNlC
                        LkH7XMca5W4iz7K0vI3a610S5G+hQFmLtQpKaYFqT6iFwmWVahWRULSsItXusmItFM83V6JWuxI5
                        QckWSmWllZZShmpnpoWyZaVrlWuhfIpqh5SK9UoKKrXQQlkJqu2LLbQUl9aylGKCjgmaqdfxakVr
                        daKFTkaopup1SkphQfe00L2hGk2WdVpKQUH3tdD9ZQVqNPFACz3kr9XDLfSIt0bj1Xq0LE+tHmuh
                        D7mbauzD9XIJ+oiLjH/MTSY/6Sf991s4CjUAyqfVpiUBlEGdzlOE16b30ZlrsA5t6hU0NdomZL2o
                        gUZnoo/zJHsU9tiHED45N8CyO0ZYX5woo1mi8Ee/rfDFtlOA9MfGUaw/3sV4Ile2ORyrGmtdoU2+
                        kbfkHul0HyfwSThTGgAZjokl8zPGkmbEYi2Ni8X+mnXFTmigYURQxlARVSAPn/F7WHOqo+W+1+/z
                        OkEZBxxhA4HbxE1qHMJaAOXftqdSrxCLnBU72PlIyjDwWXK46zFB3WU9WqNDPS3U+0hz9dXrYUH9
                        gg5KaeCh5hqs09CDTXVguF4PCBppodGy7m/UmKD99Rq/r7kmyjpdq8lGzZY1dW9zTdfrHkEzjdpX
                        1vayTjVqRxPtPCmpvbuqdULQ7hbaU9bxWu1t1J6y9h2T1qyUlgXtb67dB8paqtXBFjq02FyHBe06
                        vFCrIy10tNRcc4J2VlQUNC8hbb0KgnTNtUNfVr5RhnrlBBlbyCRouynbKHMTWTLSsjZqxpoWZGsh
                        e1mpWjmklKSadraQq6xErdwS8pQVp5oqy9tCvlhz+Ws16Y8KCrRQMCKtkJTCVBPhFoqUFapVtIVi
                        QapxKcXrFRCUaKFkWX6qsVQLpX3SykjJKygraLReuWp5apVvoYKbaqReRSm5BJVaaMFZo+GyFqXk
                        ELTUQstl2Ws0dKyFjttqdaKFTlprNFitU2VZanVPC91rbqqB0/UyCbrPRAYfMJPhh22k/z7zNgo1
                        7Hw2qrEcq4Byh+MEYbUZB525BkNQ5g2p4U0HZRDrjveyjkivwhG/j/dnCO9LEcYL8OeLEhW8PTPe
                        aILzxdQVePTHRlhfdEIRjCgBsNs7rMd5xZHkm8VNrTFWn7qZM2W/0+GCY2CEuqEB7vQeI7w1+1lm
                        LnmpWKzBFJbkKGOJtYk/qaEnG7bj0+pwgTCOOOE9acK6Ek8oLPFDrCnTVb3vClt6SGGJDW0mKAtD
                        WIduEDcHQDmyhY+lCEynoMzH4jiE9Q8B6l8qFjkrJoNynWRQFiQBySgZlEEyKMugLIOyDMoAxTIo
                        X4igrM3u77SfqoCyxnYMQblIZ67BcGhnpSGrUJpS45sNyhQUndE+xhnrhO9x1pP4jTKcJXw4TfhI
                        mii8EQfGK9cAZDDcCdOC2NGu04sDiOR/gmnfxM2lxurT0ypz8fdq+yLhDGmitBRIh3sZYTmNowyK
                        xWoMYZi3Z8IdAYBpZ/4p7NQnzqLW7olexvqTv+MCScJAQ6cMZonCFnuENWZ6WXNmDPZ9nLGkxll7
                        Zpi1A2zbEuMoKDOE+6xwJ4fWBcpBAZQZf/g94qZcpPBHhtQZgHZo7BCUlYkkxif/722BwN+KRc6K
                        yaBcJxmUBUlAMkoGZZAMyjIoy6AsgzJAsQzKFyIoz+U7Ou0nK6CstiwRVpf++HpSrjH6wj/zpsww
                        b8gMbzoogzhXrB9H5wMAPsh645/lQ8lvK7zhksID073RgWqAZAPRDqjzcyqPEDfc5YF91GYO4nay
                        swC7hkK0w7EMcFykkKy2LxCltfgUb0jvpjsjYYwx8Tbenv14h39ZSAdH8ylnCG9PXSYWodbuiTnV
                        CQBUXxRgHuDUG/nJVkfkSs6YfcM2Xfr1vCX3GqUx8kqacs4RewPnTl2PsMza42O4vwo3QHM1JKNW
                        AGWFPzSEMcpcMPYf4mZc1B6IHFZn8hVQVqUyCMoPne10ejIo10kGZUESkIySQRkkg7IMyjIoy6AM
                        UCyD8gUIyoqjmZtUxgVSznyhMpXQo/w9hElaYI2m0CXfXUkTJwXIZa0DlCtyRLuxAx/riQ6znkgX
                        izmVqwBS4Y/0c/7IEGtLfl2JA4FAY4ed9OClgGPmkq/jTfmPd7pOEN6Iw1RnCIZdKC25H7DGVNP8
                        0ZwleTdny/xQ44V6cGQ+W4ZoAgDM9vRnFZbkG8Vi1BhP6G1sIPEbLpQgAOyEj6eIIhBomZKNc2Xe
                        yjvT/6ZwJ9+IcdmsMzpcs88rgjLsbyA8vMUXe61Y5UVMKBxXpXIVUNZk8wjKYXH2WTMZlOskg7Ig
                        CUhGyaAMkkFZBmUZlGVQBiiWQfkCBGXuSOat3Hz2aaWhSEFZaSwAKKef2DqXqXgm12LoreQN6Vt4
                        Y2ryrIEyCOEYPclSAMn6I72MNzYDoPxD3pGjoMyZcs9yc1kPq8t+vcN+nHD6LIByjnS6jmPIxUfa
                        51OSuZhnL7roj2A/ZpWOwtMqHFLbnCS8M0fUvkWoNx3FYaLFojWm8IQeUsUBUgMRok7nsBOdT5zV
                        0jBjBWbwUDgjozX7LLGf1aCMkKwIBvth+RfSigh5gSIQ+bQykRZAGRo1dSaLg43ALp1dk0G5TjIo
                        C5KAZJQMyiAZlGVQlkFZBmWAYhmUL0BQRs8xgPJPlMYFCsp00BFTiTDGTE3s7VpMFX7oLzhjsp23
                        pCYlIRm1QVCuAcd6gAxEuxXO6D7Gkvw1hkbQ/Mb6NN0vlRlT4WWI0lwkGHrBGTKRtnmvAJd1xtuj
                        L+FsuazGs0x4e55CstqNo+/lnoTtnRKLSRqA+k5VIk9BWZXMIKx+9FKv90/F2S2Nc8XaWVd0rOn+
                        SoAyEwyPsKGQavjkSTrYCNTxUkUg/ENhVL4IYaFx4+MJAtPWPJjMWk0G5TrJoCxIApJRMiiDZFCW
                        QVkGZRmUAYplUL4AQRmNm899Qm0BaKRxylnS6TwBYJndL85elzFzyb/njWkGByFRGNND5xqUGU/i
                        AGtJPMHZAZQtabpfdP/0WaKxLSEoP8EashPi5jaYwpi8grfmPqfxHYPlhTo0viUA5uy3WVP8ZrFY
                        U1O4ozcpowDI0ADx0SRRBMOPb4m4XynObmo93k/9Kewzv1aPsiIQmuCD0VugihdgPQDoVzKh6FNs
                        GHMoRwgXEXIot/t8mzqKoZTJoFwnGZQFSUAySgZlkAzKMijLoCyDMkCxDMoXKijrcsGOSoc+BEmA
                        Q112WZy9brtl1vtXAJw3tZtSw/BZC8vnApStAMq2DIVjTgvSC+nveFPhW7w2eZO4mQ3GGlMcQPJP
                        Ne4lHGwER+cDSD5GlPbcwwptqCYeuZlt8STexngjv+XCCcJRWA09wcaDKw700W5PvQL3uaFDn9R+
                        VoOyLzTBBWPvFKu5iPEHR8505ENvchLDLv6Pja8v9nwtJoNynWRQFiQBySgZlEEyKMugLIOyDMoA
                        xTIoX6igPJ8d0dgwbjdPQZl26NNlvrOeEe7q7dIe758qzBmlwpQePbegHJtlzcnf8kahk2L5BUBp
                        LN63TRd5vbh5NdYD28ob01qVvQhQXCSsKQWfBaJ2LRDGkvLcNq1tmVYNIPeyq8Tho3lv9DWMN/p9
                        PpKkeYzRo8t7AjXZMaQMAP9K1hmfaLm/daCMHfkYf3hkWzj8L2I1F7H+UOxMRz6Mk84irC/ALOpx
                        Ppsmg3KdZFAWJAHJKBmUQTIoy6Asg7IMygDFMihfqKB8NP9OgMlnhA59WcJD48bpc88q9YUrxSLr
                        tjZH7m8YU7oHoHP4XIEygGMv643vANj/sdIgDM+tti5herj4lnHjX4qbVmNbDkdeqTTnlzs8x4nS
                        mqNDWCMgc7bc7xSW5JBYTNJU4fBfcM60n7XFf4qAjNPa/f6XMf7YN/moMOAHF40T1hsSxg1vYsPW
                        k3/e7oqrFM54bdhF/f7WgTIbiA6zoUgXjg6I9WzJZv+y3Rf6GmbboKAMDRsF5UBoD13RWTYZlOsk
                        g7IgCUhGyaAMkkFZBmUZlGVQBiiWQfkCBeWe2eW/YrXZ/1OZFykoozowTlmX3SsWWbd1GrMv5izp
                        oXMLyrEhxhPdxs7nPlmOvUaPOatNdYibVWOMPnElZ859CYew5kwZOoR1h+cYQHL+q+2m1DViMUlT
                        WEJv5BzZBzvDxwljSzy91ZJ5K07vCKRewXij360GZYXbXzPgSb1xtthrWWdyVOFYYx5lPw5dHcGh
                        q6m3mAvF/pMNnolPZsMxUJQogtGrcP7ZNhmU6ySDsiAJSEbJoAySQVkGZRmUZVAGKJZB+QIFZTT0
                        tnY4ME5ZAGWNHQEz/Yg4e92G3lbWnOpgz2HoBeuLjrFx36vYuXyuw3ZCBGUcpjvtFzerYpwh2aO0
                        Fn6JeZY5I47Olxcg2Zq7p21e8A43M4y/5hzpb2sC8ILhSNM0dIxLGPZ6my/6rwpv9GcYo8yGBFDl
                        A4GL6YJNjHVmLmcciUnJfZbYT5TCGxpifaGJ9kC0UrfCH96nTpdH5IsQzHyhCIS/dS7ik9E2AsqH
                        ex4jR3s+TI72fahKMK33MXIEdHgVoHyk/1FyZADKD+CnqMFHyOGBJsBcB8pHhh8mR4eh/BD8bgLK
                        h4YfIodHHgbhJ2j0IXIIdHAE5q8RlA+OPUAOjT9IDo9DPaIOTrSAZRGUDwAcH5q8n+oATqsC5GpQ
                        PjAF65i+j2r/VCM0H5yBeaDVgPLszL3kwPbT5OBOWAZ0YAeU31EHzFKQjJKAZFQZkvfvvofs3wPl
                        dsPvKjDeB8Lp+/eK85qA8uw+KDcL9VRptqz9UM+sBDDXQfK+/VDPAUF7D8A0CUhGlUF5D8DxvkOw
                        HGjPQZgmBcii9gAI7zuyLK2jgvYcqYNlEYr3zC2SvXNQx1GYXwXKu0F752EeaPecMG09oLxLVyJ7
                        9LAeKvwOMpzRbgOUkwDlXYYC2W0s1soE040wfw2gvNOcJ7utsJw1L8gC0xGGVwDlHdYs2WUXtBO+
                        14PyTpznAAC3ibBcBcbb7TDfWSVXWemKdkC7Xg/J250pstMtaAZBWAqSQds9KbLDi0rWyidoO3yX
                        AuUZgODt/oSgwBnNwO9p3+pBeToA9YRAYagzHCMz8ByaCkoAclnVcFytKkCejkTJTDQKn/j7DBRP
                        AhBPx2A+iMJxFShPxWBeHMrEAIQlQHkqAfOTUA7KNIAyAPFkEsqgUvUKUk2moZwEJOP0qaw4vw6U
                        J7IwPwflMmemSUIyagVQHgcYnij6ajRWWD0ojxU8ZLwEdSyAljxkYhGmlwCEVwDlsUUXGV+CzyUJ
                        QBY1CgA8duyMRss6fkYjS9KgPHocdALKnBDhuAqURwCAx07aYd7qQHn4lI2M3ivqtI2MwOfQyTpI
                        rgPlYYDi4dNVuq8sS0WScFwtCUAua32grMupNdZlwuuFeF4lNHacPvNbhSH5ZrHIuo235i9mzKmR
                        mg59ZwmUFd7IKOePaXC9rDa/q8N6nIIyhl6w2sxnyjHEV80CwBsydrVtkahsJTo6H36qHQuEM6WM
                        qtnZv8ByzYy1JaeVzvwTKm+RsNYEUbrhuDnhJcMleJRZX/xdjD/2DBuMES4Sx6wXv94Wjf4rXbiJ
                        KWzJK9pdawNl1hceZnzhPsbl+ntayezsHwEof0yZoCnpqNSZHK4/SeefA1svKB8GHeh5mGzvupfM
                        dN9DtldpZ/e9ZG/P/eQIQDOqFSjv6L2XTPeeIjNV2tF3D9nbfz85OgjrGXikKSgfGHyQ7Bg4Rab7
                        T5DdA/eSQxKgfBAgeffgaTI9cKKimcETZOcQwNwIrGMUtgOgeTWgfBgAGUF5evg4GRookf7+Ahkd
                        BOgZvYccnoD1jUsAM4Xk+8i+8XvI1Mgy1Z7xU+RAHSSXQXlm7DiZHFui2jsJMFoFy/umoI7xZTI5
                        DvPgeytQPrTjNNkzfYqMjy+QgdEc6RvJkdHxItkzcxKgGeraACjv2XmCTE4vkPGpItmxA+BThGWE
                        5N27jpOJmRIZnwbg2wlA2QSUp3fC8tuLZKJK+Bs1tqNApnYB9LUA5b0AyTN7FsjYzjwZB+2ahWMi
                        AcllUN4D2jEL5XflqPD7HglAppAM2nGgRMb2ZEFQvl574VjuzZLx2ZwkKOP0kb0ZMnUAgFKchpC8
                        /TBcL7MZqhn4jtPWCsq7dEUyfTRPRg6kRaUEHTyjsUMAjVVe5jIojx/NkOFDSTJSpdEjKTI5nyG7
                        4Bmy2wTncwVQ3m0pkGlDhgweipPOvWHSPRshw0cADgGSEZglIRm0A0B40pAiQ3NxMnQ0TibgO4Jz
                        GZJx/rg+SQbnYmTCCGBaA8lpMm6CefMxMqQVpSsrCr+jZBA0ZgLIrAPlKVuSlhnURci4FeY3geUR
                        c4wMGiKNMqLCZNgMwFkHygjJE84YGYD5AyaQWdAgaNgGcAogvSMoArMUIItCQJ7wRkmfMUg0R32k
                        Y95H+i0AjQDECM0VOK5WNRxXqwqUBx1B0mcLkGE3QGiV53g8GCL9jgDVeAgAWJw+GYXt9gVIr91H
                        hrwAp3WQjBpw+0mfA+ZDuQkA4woow/fRSID0uXykF9TnrpcX5oG8AKwSnuUBn5f0uj1kMOirAeVR
                        +Oz1eUiPx0OGIjAvvX5QngQoHoXPbp+LqKwOKvw+AtMmSjBvBVAeXxBAuTfsAvZwEKXNTjq9DjKU
                        AQgGYKZQ3ASUe+MO0hVykL4EeoslIBmmDeZheyJ20h2tU0xQF3wfLJRhGSBYBOUh+OxJ2EhXzEa6
                        EwDDNZDsIIMlWDZmJT0pgOAWoDx8HGAaoLivaCXqsIVwbjNRBiykO2slI/cIAC0FygjJ/UtW0pGy
                        kM40CD8zZZlJR9pMP/uPIwzXwXG1JAC5rHWBMjtffBWjzf5CaRTilDFTRIfjOA5n3TSF2loMR7Zj
                        zZmxs+5R9kcn2UD8Wlwna8hfqzLhqIN5whsQ/PO/V2gLb1Tpci9XGvP3deDofCYAXGOajtzHm/K/
                        YozpTrrBTYydtf4da8+G1d5FonTmCGw3UXkKhHflngF43tU2m/szWs4XuVMYcCQqeHRD4W9wsdhL
                        aSVNjHEU/hn2d2RNQ1hj2AWsCxanYRftnuhlbCj6pJBpA+OTowQHHVEEg0qcfy5svaB8tOdDZKrr
                        FHkvayDvYXXkXayWXMHOkXey8+Q/4ff7OTPZogqRPb0IzLBMHSgf7gcA7n+I3KJ0k3cxWrrMO5l5
                        Kvx+DW8hW9UhsrPvXnKkGpZFSD48+AjZM3AfuZ63kcuZo4TrjFPPcj0oHxl5hKi7knQd72H1tP53
                        w/f3cQbyAaWdMJ1RCs1HAJhbgfKRsYfI5NAxcqvGQ+u6VHGE6jLFUfJ+HhqD3jQ5CKB8QAKUD08+
                        QMaHF+mxehesv28gSw5PPdAAyvsn74P6heOBYnuj5ND0/RSSD0yfJjsmjpOreROtZ2bimOhZBjCu
                        A+WD20+TAQDjD6ht5ApmjlzaDtsKulwxRz6gsgE4Z6l3eT2gvH8XvMxsXyZXK03kCqhPNRglB/fC
                        i43oSR6ZypP3cHp6PfSNpcmBfTCvCpT3gWb3niB3dON+Cuf6nQo471W6rP0ouanLQfbOwjISoIyQ
                        vHt2mZbBOvBYacZjZP/BE01Bed+h42RwR5quj27bTIrMHj4mCcr7YHrf9iS5on0O9lGoH6+d98J+
                        vVvc3su2HSUf6LSS3QDIKATl3UcXyY7DJTr9Mli2bchL9s0tUVDep10kA7uTdHmsr3N7lOybX1wz
                        KO81LJCunVG4hnXCcYa6qo/d5dvmyPvVJjI9B1Crh2VEUN4Fz4o7h+GYK8R7DT6xPNZzlcpIbhuA
                        B+7BBACz6FWWgmRzgXTsDpFrO8zkim1wDLbOUWGdN/XZyODhONllk4bl3Y4c4Xf6aVm8/27osZAp
                        EwC9TYDlXY4suWvMRS5rmyPK3X6yy5mtgPIuV5a0b/fSebjdWAfuOwq3/53tWjrv7gkn9SyXIXmn
                        O00G5iPCcYJlNAcCZKc33QDJ6E2+bdQu1gvnR1xHWZdvnSfX9ZjIlAvguOJNTpAd/gTpOhqg+1Ne
                        DrcFP9/L68n1vWbCzXoAhuNkGsMqJCB5Jhgn6iM+ck23kVwB67m8DY7rFrjmoI4PDllIvzUoDcv1
                        gFwWQnI4QqbDUXLLmJVu+weHzNSjTD3J8QjpNHrpNYDC7zgNIRm9yTePWWA7oO057CLTCQBoEZDR
                        wzweDpHr+02wjVpy53YbmU7CPBGU0ZPc44B68Xxsg2MAx+E/4Zi8B44DvefgN+7f+1R6Mhz2k4mU
                        AMgTyQAF5xuGoF7Y79tnLGQyDfPQk5wBgA56yfvUerpNWw/ayVQeyq8DlCcLPtLpcpHrB410+y7f
                        ArobzhfUe92AEcDXKcJyFSRXgTJ6kBGQb5o00Xv4MlgWdQXU8/5uA+EsdjKGsFwHytTbDLpxzEjX
                        efO0UdKrPH7MRXinlbxbgcdMRz/ftQ2Pm/gJumKLjqh9NjJ24gwooye5L2Mn7++BewGWwWPNQT3j
                        p6AMgPLYKXgh8Fnpfl4/bACoFoC4AZLR2wzT23QmcmUnHG/Yt8vvgn28U7i2b9tnJP2LNgrM9aA8
                        er+VsADVuK247dXbjHrnVtgfmNaRAqC9XwKQy5IA5LLWBcponDa7SEetE0FZY1vG7BcfvugisqFM
                        CbOE/BFjSbax5tTZBWVPeIT1xgfKQMq4kn/PzWe/obYIsdcqUxHBf4HVZb/Y4YT9NODofPBC4D5O
                        eHP+Czj8Nt3gJsYYQ2/jrOlP0KGrbRk6lLXGv0h4R+b7+CIgFqOGIwOWR+ZTJbOYw/hDOGqhOFvS
                        aA5lR4Jn3avvzFcfdsEGwkc1aWGgExp2EaWDjPyUjcf/SSxy1m2joPxuBGSAsa3qMOnvLJLujhwF
                        ZJx+seIwuUPlJ4cBlFFSoHyT0kkuZQ6TG5XwVtyZJz1decJ1xMlVnIkuj9P39d9/JhSjDpSvBaC+
                        BMoxnbGmoKwEUL6MOULhmOuKEXV3ktzdEaDwg+tA+BzrXxJgWQKUj4w9SKYBkuk2tR8i1yttpKcv
                        SwYHimRbV5ju/+UAzJ0Ay+hZbgbK2Igh1LcC5Zs1TlofCl9AJkYXAZbvq4DylbyB1tMMlA/tuI/0
                        D2cpQCHI39LpJn0jWarbOj0UmHH54bGC4FmWgmSUBCSjyqCM23HptiOElwBlBAeE6N4WoHwbgDJu
                        yzUqM1GORIkKhJ8objhMeiaTtd7kKlDef+AEGZoR9hF1OUDpzQjW+xGiW4PyuwAO6ba1AOU9h5bJ
                        +N48aR/xE2YkSLYN++n+IjTfABDMjgXpPPVkpMajXAbl6zRmcsnWI+RuCVBGOEUA3wgodwIoX9Eu
                        vPC1jXoJPx0k3JQgdjJA1NvDZLs2T3ZVeZQRlG8fdJFLAWzfrzER5fYgUe8MEWbKT66B35e2HQVg
                        NpDRw0myG2FZApI1u0IAggjj8+SOYSfpmY2Qjr0h8oFui7i8kQwfBVi2NsJyGZRxWQqfAPSKGS+d
                        vkME5TtGnOSSu+GaqgPlHY4M6T0cIW1TbgBmD7lzzCkAMtRz65CdKGBa25SLdB0MkR3OM97kMihj
                        2Stgfa1A+dYRO4Xtq9QGotjlIczuM2qH36oDvgaPchmUr0AwhG25a9pJVId8hJ31kltGbAKQARwq
                        9rjJdgDiekjGaZ3zwssD1nHntIN0af1EddhLIfviO+coWA7aQ2Q6VAfL9YBcluhN3h6LEuYAvnjM
                        k/cqoQ5ngIZazAAUt+1xUNi9HOBpyy4HAHEEIDlCRvxBcpUGXuZhe/rsPiG8og6Ur+2Fa+UuANrp
                        WlBG7/Kg30+27rOTLXsFYV0IuNf2GknbLE6zkW0HAO6iAiBXg/L1A0K9t041gjLC9mV3z5Ot+9cH
                        yhN5H+n1uemxpLAKsKuyOYnS4iQ3TcB674RrEkC+w4WwXOdVRk8yTOuPusnVXdDmQdmru/REobcB
                        XNvJbTvhpRGOJS6vgt8Vz3IdKH9gxAjLwsvPZAtQdiDQCnB52x4T2aa3kLb5Ks1ZSG/KTkaWG0H5
                        KoBbXJaCe6+eDBQx1EIAZSWAMkLvtYNNQBl+j5yykzsPwssKfXmA9c8aCe+zkG1mAGeNjlx6Oxy3
                        nXB/n7KR4XIYRhUoM044DgDyeK/dftBItsJyWwwoI1Wb0Uh6Fyxk6LQEIJclAchlrR+U5zLKSvgF
                        HeK5gBkwnub0qUp+3vVYz6z3rxhjohPDL84mKCt80YmtntAl4mqpARR7hRzRQuy12rpIVBYchRBH
                        58uTDucx9Cov3Hm4NUgy5sRdnD37fY13kQIyB42tJgDLOrIfbTdFGgbxAIjNlT3K6lQeQTkszmpp
                        rCv9vtWmh2N98WHOH+kpxx5j1gvGH/qqMpaqgDLNpRwI52jl58g2CsoIXQh1w12LxNj/cTLf92Gi
                        6/sIaQNwvgQA+ErOSPZSr3I5BKMWlG9WuijotqlDRDvwETI/8CGiG/owGe5ZJO8UIXwIvs8NPioJ
                        ytfxVgqEbAtQVlFQFjy/e4dOk/nRRykUTw+egOVtsP4jANxWsmf4NDk09lANKB8EHRp9kNyh8dLt
                        RE/3jpFTZG7iEXJk/GFyZOJhsrUrRN627QCdt3fs3tqY5SpQRjDH/WkFyrdoXBT+rlFZKFTf2uEm
                        B6ZO05hlBOWreCOtRwqUD2y/l+yZPkmuU8ExAQi9ucNJO/Md3gkvGiDs0PdBjYO8re0AQLOb7C/H
                        LK8DlHE70POrlABlvCbQc98KlG8HUL4EQPuWbhc5OHsKdA/ZD59U+zFW+UQLUD5J2gb8FFzv7PVQ
                        Ty96Dcd35cnsweMtQRnhkm5bC1BG7Tm8ROORDxw9RnYeXCDXAvyiF1kxEiAH52Efji6TvUcBgiVA
                        +foOAEcou0UClMse4M0AZTzOowfTZL9pkew1lirCOOVy2EU1KN8xhKB8lHyw10p2w/Nir7lE9llL
                        NPziSiVAAMxjpnxkD0BxNSSjl3kK2uD3a+BhDzB564CD7LLkyR5bnuy1F8jYfJJCNsLy7QDQOwGU
                        d1iagzKCOvU2gobn43QegvKdo/DSvOVoAyhTWKYxylmyx50jw9qYcI3BMeg6GCR7fTkar7zDecab
                        XA3K5bIreZQRlD8AgLrdkyS7/LC8D4SfIIxTbgbKZS9yjy5IdkehbDAJSpDbxmywP3PUGz3pjTZ4
                        ldGbfCuWuXuO3NBvJjsiCbIrBvVG42TEGabTbhgwkz4zQG69V7kekMsSQRljk/usfnqccfs6dB4K
                        yRhmccMg/iMAbStALH7HsIuZZJR0GL10+vV9JhqSUR16UQbl62AeQusdM7WgXIZljEeezkD5ZJB8
                        AOCXlt1uJTO5EJnKwPy6GOUyKH9gUCh723QjKCPoo7d564H1gfJU0UfaDljJZQCLV3UayEgajsUx
                        P5la9NHOfDdPmsl1/QaAZwcZLzaCMnqTb98F9z9A5HtgW7r8TjJ9zEumjsG8JQ/1Ml986zy5dgDq
                        LohwXAfKN4xCewnrv2lqBVDGly4A5Y6gjUze6yZjx11k7MQZ1ccoV0AZ4B3P9dXdcKxgO+86Yibj
                        9zgroIwAfd2QNCiPQBlNxCq8UEK52/ebyNh9dqqJh2yE91vIO/HFCrYfQzEwbrkBlF1mKCN4tLuy
                        FjL2iJWMwPSRByyC7gdIloLjakkAclnrBmWaoUKbeZwO84yDdIBwlD4ATKdYZF2Gnl3WkhmoyXyx
                        6aAcnWS9kdswRldcLTVel303byg8S0MvEJbF/cJ9VFpLzzCG7IG2ttwfi8UljLwAtneWd+SfUbmK
                        dBhr3pkjau8CAnP0dnP4RWLBio1ns3+pcIe/VB6ZTxjCOjgizm5p28zpf4F9bgy/qN7XskcZ9hle
                        Dm4QF8Vwj63KeBrWBW/+AMqYbUMZT6FHucbbfbZts0FZC6CMsHynKkDewRykAHqgD8C2iUe5DMpb
                        AJTnAJKxcx+C8lTvCeqVRlgc7C5tGijvHDxFDo0IMcnzY4+Sgd4CBSdcT1dPhhwZK3uVBVA+PPYg
                        2T50grwPgB/DLBRdEQrH5YwX2LFvZuQ4UfbGydAggAyAck34xTpAGT2e6r4EuVFtp/vWM5ghR7c/
                        uCIoozcZQy5wf64AdQ+lYZoAyCj0IKMnWTkQIyPwuXcDoRdlUFYPwXGfvY8cAFg+vO80GZ8pCmCy
                        AVCW7MgngjJ24Nu+Z5FcpTRSTewqkBs6ADbQuz0algy/WA8olzNc7AVgntlfrIAyepexI59U1ot6
                        UN467CMHdbDN80vkoGGZDO9NnwVQTtWA8p66jnySoNxjJTsNeRqTvNdSItPaLLlaBRAM89onG0F5
                        j6VAuvZGqAcXpdkdInttxUqmi93WPECui4ZhXK2Gc6JPk5118cplUEbQRpjeOukhlwAU3zZkp534
                        cH4rUC5rpyNDBuaiFfjt2B8gu9wZyawX6wVl7MRXDco1HflagHK3Nkh2hqG+AABvOEXunHKQywCU
                        r+2GY+JpBGX0KN85BeuFMujtVB7y0lhlDLXYHomTKXgeoSdZslOfFCSjRFCeCgMUw2+EdAzlQM/x
                        jlSUDDgD9O/xa3rg/tEY6MvKgCtAdqSjZNssHP+75shdO+1kBsMuqjrzrQaUK8CcCJKxaICGaWDZ
                        22esZDJVC8jNQPn27RYyUwCgBiCeLgbJcNS3YVDG2OT2ozbqTcZrYeshgLwEQC5Mn1yAMnmvINqp
                        rwqSQeNFDxlMojdZ8EYjFI8DOI8WYD5AMYKyymmnHuM7ZwH2MpsFynYyeVoE5ZMCJEtlvaj2KON5
                        ZSwWuJZEYI0BbN/vXBGUR++xA1hj6ItwfDrjAL/YgU/s2Dd4zEZu2WUkN04ZiDII0FsOv2gCyt05
                        EZQfEECZhlucj6wXZeN0aWenA+C4Cijh84esaf1/3W/RZ1/LGFMjCkvVUNabB8ojCld0mnHH1G1e
                        7wvFVZ4xAGdWmzlZHVKihMZcacg/zpkyt4qlJE1hSP4Db83mNB4cujpPIVnlhuNhzz3JmuPTYrEG
                        o3HCvtgTbDBBsDMfAOuzbKh1DuWyKbzJf2Ds0T7WGR1usr8UkjEFHrwYjDKBxD+Li17E+MMPYJgH
                        9SaDEJLb/eGv3RYItBwoZbNto6AsxCfPk7tUfqLRpAmniZNblR4KueitHe1eJkf7qzv0SYMyhmjs
                        7r2P7O47TSZ7j5NbVG6AxMM01nlX371nOvVtIihjJz6MT8aQisugji0dQQDjWo8yxiYP95dE+Jyj
                        IReY6QIhGT8Rmo9OPkS0U4+CHmns0LcOUEYg7xvKkeHhIv1+jdJCO/btmjy5Iigr+2N0GSwzMb5A
                        s14IkHwfObTzNDmy6z4yv/sBcnQXAnQdHFdLApJR1aCMHt1bOqEhHooSbjBCePjc0uejjSXGDq8E
                        ygjaGHrBDoUrah+Ah+NMDoBY2qOMYRedEwkKorf3uMmhQyfJtsEAhW4EZgTj+gwY5wOUMRwEwzS4
                        8RBhxoKEmwiSuwbd1GuzGaCM4IfHGcMtevfESffuGOnaBSA0m2gJypcBDGOoxNjhFJk4miEj8InT
                        MRQC40sHDsQbQi8QlNkZwRuMYDV4KEF2W/I1oMzM+GgdGJs7fBS2oS78ohaUHWTKmCLXdMDDGers
                        mg2RfW6E7fMLyhgmcRWA/rYd7oratrtIz3xIMutFPSgrDwJ0OaNkxAbtOXxHwEOP8t0zDsnQi5lA
                        nAxaQuRqAFaEZYzhvaYLgGvaQTv0jfsiAMzrA+WyV/mu7fCyffcc+eCwhWxPRIlyDu47gE7Ffhe5
                        bQrhcR6mecj2ZJR8cESIT9boPUJ88jkGZQxhuK4Pjj8AMUIxxiTftcdGrzmct15QxkwXQ3EPjU/G
                        7UEgvKrDQG7bYSac0UEGEZoXoawUKJe8pCfkqmzDloNW6mGmscvoPUYBEI8tCGoWo7xaUEZIxljj
                        W3eZaKjF3UfM5K5DZrLNYCFDpcasF9WgjG1Lb9pO2rTwon67FsDWSMbvdRKVvwUow/fhk3Zy03Zo
                        z++G49Ktp535aMe9cnq4kwIw0w595bALKVDeKoDybfuNZIveRO7WmshdR42k3Q5Ae/I8eZTRWH3m
                        ct6Qf0qJI9qJsEw79RnSu8QiazbWmHkXa05PVCB5g6BMva3u2DjjQi9yvLfdHbteyrNbNsV89gq6
                        TwDIFP4tC4Q3ZL/Srk29QizSYApj8grOmv1/Hb5jhLNkCGtJE41vCSH5W4w5/UGxmKQx7shUR3qR
                        8NE06cwtYOjDN9u8uUaIlzClO/tKhOQVPcr+2Djvj95VjnsGML6SC8efwVR0AihHiYYOYR0+Qis+
                        h7ZxUIYbFKD4vfCJMcDY0eydAIPoob1d5aPwiynjWoEywiPeYFhXGbyxY+ANSgcZ7zlG08VRSN50
                        UH6Q7B0+Ta5XCnXc2eGXBOWB/iKFKxR+PyKCsqIrSm5Ru8gdHV5yV6cP5CfbR45vOPQCQbdrIE2O
                        zjxI7oR637HtEGF6I2TPJEA9b6L1NANlTgRlDEegZWDazukT5K5uH7mlA7a1ywPykq29QbJrBqB1
                        5/pDL9A7iucePyuC3+UOayuBMnrO8bxXCwFTNRolBw6cbABl7NyHHuVbugGoAFp7p1Jk7si9ZHRH
                        jm4HLj+8I0v214VfnA9QFjrK1R4b/I3biF7ZDYMy1IF1VeqH3+jRvbHHRuF4F8CxFCiXPdF4n6Ho
                        360wDcMhOvdEaLq4+s58Z0B5DoBBT0aPJmnoRTUoc9vPgPTA4VhDnHI1KN8yYCd7nDnSuS9Et/na
                        ThPt0HfXuOu8gjJ2UMSy1cJpCMytQi/w2GNZekxh//E7wjN+3jUFbZgr1rQzHwL0kC0McGwnV3cI
                        HfouuQugeZuWvL/TSNgDbjIVQjBeOyhjnLJG66VeyivVcN78IXLHNMZOz5N+Z4BwR9zUg4zQOxYK
                        Uw/z+wDuMeMFduw716CMcb54PSIoot4lftLzAAC/XlDGznwYp4ywvGXWSq7pgWcUHJNL7xCg+UqN
                        ntx9AEAwi17lRlDu9jvpSySF9SONoEzDLRCMxe8bBWXcXyrxWsJp1/YbhIwXND65CSjDseqOw34s
                        O8j7+ww0BIP3WElHZAVQPmGnUI2hFdcM6En/ggjE1XmU8Xc1JLcA5Wrhtl8/qicDJwCUW2W8QEkA
                        clkbAmU0Vpu9p8MBgCiCMnaGYw2Zb9w+2xxGWxlrSN3GmpObAsqip3VkmyvyQdYd/PdOf/bF4mpa
                        GjOf0XU6T57ZJ9sivPllvywVf80a4xxvzf9E7V4iAPgEgBkgGY6HPfcwd9T/BrGYpF01O/snjCf6
                        gDKa+Tnji36FjyQ+qghEV505hHOk3rlSjLLCi95k7PCXfJ242EXt3vCiGoesFr3JmPWCDUV/wwbi
                        bxKLnDPbrNCLro4c2df7INndcx+Z7jpJ7gBIvpQ5Qj3CO3vuJUf7P9QUlBFib1DaiaYzTdiOOIU8
                        BO3ergINw6hA8iaDMuZTxt9XiWEV2zrDDaEXCMqDAMcYyoAvAOhRLoPy7RovjcEWlsesEkcpEB+a
                        AAjeBFCe2/4gmRpbpsfjP2HZ/qEc9S63AmVeBGU8L5gaDqftmDpOPqCxkath/98LLzOXtAsdG3dM
                        HyP7NwDKCLVb++BhN1MiI1MFMj5dJJ2jCbpuCqMrgDKGS9zYYa9JDzcG2r4bALUOklGYX3lshxAD
                        jcekezJJf/dPp8n7VfBQBpBtHwo0hF+cD1DGsrf1ucjoviwZ2pOmKeHUU2EKtZsZeqGaCZHB2QTp
                        2xcnvXvjZPhAsgLIUqBczoqhmPTTjnwYKnEZTNs64SWz1gXJ9HAIypwIyrjOVh5l7Hi1kkcZQRnz
                        KO+0Zel3DMFgd/jIlgm4Js4jKGPoxbVd8PDVh8kQpoUzRMiAIUzGbDEh20ULjzJeV7eP2wm7z0Nu
                        HhayTSDoTgAkbw8mJCEZhV7lnVGoK5wgY+4o7dx314wDwFboCIegjrDckPlCCpJRVaCMeZRHPCEA
                        YD2FUITma3uM5OpOA0BvmPTZ/RRMMSZZpfVQeLxp1CxAMgLyOQZl9G5/ENaPaeK6XR7SA59qs4v+
                        S7GR0AsKyjkvmV70kakFHxlOeWjHvS0Ax5ixAgEYofLOvRYaakEhuNqjHDzjUW471AjKYwDCE8tQ
                        dql51os1hV606whjspLepIOmhEP1JACMawYfkQblrqiNTN7nJLxLgGPswMc6LBRYV/Io4zG4uldP
                        +kp1HmXQ6Gk7GbsfyuL0ZqAshl6wHjPpygup4jA1XHceYPd8hl6g8dr8LYLXVejUh8IsEYw+NSkW
                        WbVhujTOlGEVpuSGBxyhnlZnZJTxJN4mVr9q22LM/iWryzzc6ToDyxr7ElGZCz/FwVCumn3oTy4i
                        5AW8OatV24tEBWJNKaK0F4jKtUBYS8p1m1a7YghD2+zsn2EO5S0OAGqoT5y8KlOZwy9iXcku2OeR
                        GkhGVYEyepPb3ZEtZW+yIhh9LxuKPU1H4hNBWY2ZL/yhNK34HNtmgfJQ5wLR932UDjSi7/8ozaWM
                        87BDX2dHhsz3f7gpKJdjlLEzn3bgw2SbJkynYfq22eqMF5sMyhij3Nubp9uP6u8rNIAyxihjxov3
                        ApwigLZ3hcnRCSFGGQcgOTr+MBkZLFGQxv2dGF7aNFA+NAPrB6n64rRz3vUqK4VyhN1moNw7nKHr
                        eKcCXl6G0pVOfLOgI7vuJ+pBoa73K80bBuUzMcqw7XtPkcP77qWwTMFkFaBMY5S7nFDmJOgUmYVP
                        HHAEPcf1kIzCTnzMUIh6osvAid/LKdzw93Uai5BTuSr84nzFKLcN+8gB7TE6+MgB/TIZ2pvadFCu
                        78y3qhhlsTPffusi4bcHKeC+T2mgnfpo2IUEKHfvjVDPKQKneleQ7LUVKqCMg47cOYJhHeUYZYDU
                        FjHKCMc7rBmy256jeZXRS43rv77bTL3S5xOUr+8xkxmAYYxTxk596Emegc8KJDcBZRqjrIPjEk+T
                        EXuUgi6memvf7SLYsU8KkjFuedAaJt36AJmE35hPGYEZwy2G7CEahoFZK7BDH4Zf1IRgSEEyqgqU
                        aZq4SITcPGqhHmrsuIfHAkMuZhJCxz4EX/RcYmgGgrliv+NMfPL5iFGesZCZfJBM5QJkuhCkuZM3
                        GqM8mvaS/rAbuMhZiU3GVHAYn4zQfOOIEJ97VYeexiNXe5XHKjHKgof2lhmzAMrlGOVFD9G4HQDA
                        JrIFIBpzKm9KjHLARibugeXLA47A5xlIbg3KYydxGQe5eYdRgOUBA53XOkYZ7j3YP4xz7kpVxSif
                        FGKUb99vJDfvNhJ1ZOUY5a6MhYw+hIONoCxkGDNdnG9Qnp0lf8ToMh/T2M94lVXQALL6zHcwblcs
                        tirD4bExN3FNxot1gjKGWjDu8HvEqtdsHdrUK3hT4fOdLjEGGwcZsRSJ2oEe8/RHWGP6EY1zkSih
                        QUZI5m159Cb/hLG0zq0sbeQF7fbUK1h7/BLOmbyDcyV7FI74tMIR3aGwx7bj/rDuuIL1x6/eZo/+
                        K8D1q9od8S1Qppd1xTsYd7Rb4Yr114My9SYH0JscrHiTFd7wMcysUYZkFhpHNhh9dps39J9ikXNq
                        m9aZr7Mq60X/RwCcF+nf4Zj6Db3NK4Hy3eogTIN6Bx6jg44gDKJHWt2ZInODj20aKAtZLx4jR0cf
                        IVMDx2mmClz/B1VOMjssZLioBmXMenEQft+qBrDDmGmE7ZGTZA5gGeOTMfsF0x2peHE3FZSnYRum
                        TpN9k/eQG9R26rFG0ENvsBQoY9aLXVMnyDUAwQjDN2kcZO8MvBiIWS8wd/JtnVA/AO5mgfLZyHpx
                        ALNe1MUoYwe/nXuXKQijJ7t9MEAGpjOkdypJ+qfh/h/BNGAYhjBPf1eHX0iB8sCODDk8B+s5AtsD
                        2g/aewjKbiIon4usF0P7k3Rkvno4rlY9KN/YYyXbdTnamQ878mGsMALsncMuGnqxsw6Ud4pZL2ga
                        OVj+lgEH9SjvAViuz3qBaePqvcnNQJnCMkzfNuOlsE6PDezXhdaZb7VZLzrnAmS7mPGibQfcZ1vm
                        yJVwXIYAhutjlMvxyRjqgN5n/qCX7IoCJIcBliNxOjIfAvKlAI+YT3ldoAyiaeL2uyiAISzhtiqP
                        umkGDMyffPdODDk5ExbUYxXTwp0nUL5tk7NejOcAhgGOr+1DUJ0nd89aqVeZgjJoatlPbtthofOu
                        7jZQcK4Jv8h7aOe923djGWh7VXrqYZ465iWTy0LWC0z59o6b4SV9wLg5HmUE5SDsK3bmw2wX2JlP
                        1EqhFwjKNC0cqCdlp9uLOZRpCESTPMqYGk7IeqGlYH3nIRP1HmN2i4mH7DRNHEI05lTGrBcjK2S9
                        qO/MV9Z5Db1A442ZNrVt6YxX2ZAlHS4cgCQ1LxZZlc3Ozv5Juym1pSaH8npA2R0bZ93xOzG0Qax6
                        XcboE/8MsPwx9CzTwUYAljlTlmgcS3TQEc6UAaUJDw0z6KeMJcGg55Z6nEXr8Xr/tM2R+5t2i/9l
                        Ckvyjaw18y7WFlcobMldAMY+1p46AZ//j3HEf8a5UkTpgxcNf56oAgWiDuWJOgjfgzm4QLKE96cJ
                        64o+Afv4XdaV+DLrij3MuhMhxhWZVTgi/ZwzpoF5PWVQZj3RCYDo26u91QpfpFgNyuhNVvhCx8XZ
                        59w2CsoIwxgmgZ35OjoyRKVJkTZViHpg0Zt8DWeh4RjN0sN9UOkk71AcJHepAxSUcbQ+HJEPvcoX
                        Kw6RKwEKd/bdcyZOuQ6UEXQxtzEOHNIMlJVdCQrTCKpYDn/fpfHDbx0se5jmRcbR+jAUQ4DkM6Bc
                        9ipPDC5RQL0Eyl+ntNIBRvr7CzQ1HIIXNhB4LFqBMv7NiRDc2wKUMY8yhkZ0iqCMg43g59BwkYIE
                        elCbhV5UvMpDabpNCLI3dThJ11CKeppv78S44Hm6nZg7eiOgTI8FZpoYjDSAMm4nDm7S0wKUb+uC
                        FyRYHgcuwQ581do64Kd5lXfvWyZ79wne5f0Azr2TKdinOeFFYc8COXQIwPrACXLw4EkKxAjRF289
                        TO7q95LZJh5lPC54DG7tdREFzZEcoGob9JH+7akzsFwHyhiugLmRtw75VgRlzKN8MeZRHvQ0gDKu
                        G0G/YwOg3AGgjOESeJzXAsq3DzrJxW1HyA3dFgrKOw0FssdcJNxMgHqDMcd032yM5kyuBmUUjsiH
                        2S4QOBFqbx+C62oftF8w7fouADoxD/PwXKJpHmVuh59cfPdRcnO/rQLKOODItDlNroM6sN7LYTu4
                        XSuDMoIpltXMrgzK5bJqgOpmoHzriJDKDcF2y7SLtM246OcW+Lx7yklzK086AWBFSK4GZQRdDJEQ
                        QFkYvnrYFoW69LQj3e0TdgrG1aCMwrhlzHqB60VIwZALHHwE8yjfPGql8cq47Zo537pCL1DYoa/X
                        4qftE3qMMYwBs1xg3mQEZY3OS+EZvd8YljEaDApp4ZqA8rU9cB/cCftUl0dZCpSv6xXK3ja9Migj
                        VGNZyTzKHBzHu+ZI23rzKBe8pP2IkPUCQRS9wtiJjzc5yG07LTQsBQFx25yNhlpUILkMyiUP6Y+5
                        qFf5Msyj3Gkg7VobUVrt5NYdmEcZ8zDriMrpaJ5HedhILrldSz440QKU7UK4xDsBam+eMdJOfHce
                        OKM7Zs2kKwYAS73LtaCMcdYIw2VQxtH5MD1cmxbzG+P+6ch1zfIoi7B8B+ZRBpjHenCAERxEZKvR
                        RK7s0JPLYNtvwjzK1bHKVaCswDzKd8MzEI7DLbuN5M6jRnLHYVGHjOR2EI7OR73LUpCMkgDksjYF
                        lBEMWV3m4xr7cgWU0fvKG7O/YvXZfxeLrcoAlC9TbChGOTHCuiO9lWGaN2h3HI2+hDVkoxinrLEv
                        UlDmjADIKBGUOXOGMKbkM4w59U3Y3v9izOmPspbkA4w5eT9rSX2EsSb/H+ibjC3xe96ZIUo3ALC/
                        RDRBqDOwSFS+POGhsUVQ5lxJKhblTlTEQcOI4r0A036ow58lyqAAzwpP7Pft7tj/MN5YCr5vb3dF
                        OxhPtE/hjgypHOGXi7tCbZs7/C9MIPptZQygOxQjbDj2rMIbvEqcfc5tI6A83XUPuZozE8wagfCC
                        cIxCkHs/APJdqiCZ6TlVFZ/cCMq3q7z0gb9VE6GgfJCC8iNkuu8kjW/GBp7rSEiC8l4A5Q8qHfQh
                        g/DbDJQ7utN0u3A7hZEEhVHWEJBxAJLdw/cCJK80Mp8AyzepXbTDGgLv5Qw84OA7wrKmVxh1rRko
                        43Q6qh6sd2Aw1xSUsWMg9ewMZiqgjMI8ylu7g3QexilvnzguCcr7QTgyH4IxhmpQYIZtLQM2PxCl
                        Hfmu5I0bAuXrVBbYFi0NvagG5dHpAvU24372j2eagvLdvcIDEAfywM9q4fVwY6ed7N4LoCyGYeyb
                        PUG29Ptgf7Tkzj4v7dS3l+ZVBhgGYf7k9qEgvRY+0GElO/YCnIqwXAbloZ0ZcqXSSIXbV71OrJcF
                        cN5XDseoA+UbOm20bmYUyqwAyh/sttF92DYCUF0FyoN7UuR9sL80vnpHbN2g3L0rRreZDvBxILVq
                        UL57RBhV8pZ+ewWUdxkLdAjr67ss9FpGmMbUcTvrQBl/78Jc9nvC5NpOM8HOhOjVRkDEF0AcmW/o
                        CI7Ml2+A5DIoq3ZjxzcdTQ+3QwRl7MS325kj3QfCNPwCY0FVewB+W4AyDmWNUP5eKNt1INgSlHFo
                        a1qW15GOg8GmoHznhJOuG0EZP6uF+4exyxMOAGXMflEFyt0Axwif6PXsmhdAecobp59bd7no/Yqd
                        5PpN0BbWwfK0P04mvTGybbeLDnSCEIdwjMcUARljhzXzvsYcymsAZSFNXIh6pxGIbxq10JALHKVv
                        Mhohw94gHRUQ5921w34m20UTUL5xyEw9l5hCbiVQvnFYKHvnTtuKoIyxye+Gfb5zJ0B1FSgPhrwU
                        TPHeaz/sWBcoj2e9NPMFq7PTmOR34XFuw2MNUNiuo9MUOhvNejFWFZ9cBmUUhltg9osbx030nNLl
                        QQiV7+81EB6geWyheYwyhmbgsbh1h6kpKCtdVnodIZi+Vylef3DdVq5DOD5Kt8TIfFk77eyHIxh2
                        x86A8gjMw+GtbxjH46cjNwKkNwNl7NCHn3fPm2gICnqhKbTDPr4HtgUHIMFhqoelRua7zwpsZKb9
                        E3DbsXxl20HlTol80EQ9y5KQjJIA5LI2BZTRWG3qNhqrDA0agjJnyNABOhhdelkssipTmLPvZoyp
                        yXWDsiM6yTpXl15tLcYbstt4c/7zHc5l6k1WWvIVUGZR5jQNv1A5S0TtXiBqD2oRVCIqdxEuwgJB
                        SOagMUWx0JCydoBh/A2AzHsAfr3oTYYGPSB4lFXUmyx4lFUIxQDJnBshOi7IHScMgrQPADqUoWL9
                        sZ8yvvgphTu8j/GEJOOz231BBaaD02QKpN0fKYiTz4utF5RRB3oeITu77yM7e043aH/PQ+Ro72N1
                        qeHOgDJ6jlGYDm577z1kT999FJKpAIgPgXb3nyY7+k5Rj3J96AXqwOCDZNfAPWT7wCmyd/B0DSSX
                        QRm1d+g+sn3wFNkxeJLsGDgJ30+SXUP3UDDGgUcwTRyF5BagjMJ0cBiXPDF0jAz0F8jAQJFMDx+n
                        YLxv7DQZGwKwksijjNo3fi/ZPnqczIweI3vHAWgbIPk0mQXtGD9BpscAxCZPkf0iJKP2T58me6fu
                        IdPjx6g3eR8FZJhXB8ploWcZBx8ZHSuSvpEcGRjNk5mpZXJwJ6wDAHl0HKBrO8CvFCSjJCAZtXfX
                        SbIHND2zRCZnFsjOHQChAMkIyqjdu46Tqe0LZArm7doF20kh+Qwol7V91yKZ3FEiU1XC31Q74bju
                        WqgJvUBN7S6RiV1FgOAlEZJRAijjqHw79y2Sid0AfiCMU672KKN27of5ewpntLdW22dLDaEXqF2g
                        qX1YBo4hQDNCshQoIxCjJvfnyfhsjkwfgO0QpyEQ7zhSJOP7s1TbD8M8hOQ1gvIubZHMzOXJ2KEM
                        GQdtnweo1UoDclkIyqjJuSwZFdPC7dDnBVEozlNYHj2SAgE46rM1kFwtjFeeMWbJwKE46doXpho6
                        AtBoBpCui0uu1g5LhkwaU2RkPkHG9bAO+E0lwvIOW4aMwfQRbYJMmlJkuwQklzVlhXoMcTKiB/C0
                        Js9AMqoKlFFT0MaPGKNQPkombAC4dZBc1pg1ToZNURDAY7XMgkYs0YbQi2kPgK4rRoZgPmrCDQAM
                        kIya9sE8D8yzRsigJUzGnACtVZB8BpZjNNxizBUhPfoA9R5jarg+c5BM+qNkJiIByWsAZQGW4Ry5
                        gqTX6idDHqgXIBlhmQIzCHMr99r8ZNhf502uAuWyMCPGgFsoi5AsBcpU4kh9/R4fGQr64TfAL0oC
                        llGDQR/p93nJUBjKJgUhEI/CZ3/AS/r8MC8K4JsWpktCMkoClLEzH8Iy5lMeSXlIpweg1OIgKquD
                        dMH34TSCMJTL13mTq0BZ8CwDSBc9AMxOorI7iNJmJ50+gNEsgG55+Oo6UC6rP+kkvVEH6U85GyCZ
                        asFFhvJQJuGoCDvw1QszXwzTFHECKCMQIwxjWrieJMDuAkxbFqbjJ8LyQNFGupM2AGobTKsF5Goh
                        LGNsMqaHU4UswDpmGmrRk7OSEZheA8lVoDx0ykoGlq10oBEMu+hC5cvCjn2gnJn0H0MYroPjakkA
                        clmbBspgL2C16XvKwz0jKCM0q+2LhDVmObHMisYZUzcq1psezp0Yb3fHt84+dCb0YTONtcb/jjVk
                        unhT7hGA5t92eI4TjWuJqBwl2pGPs+YIK6aHYy0AwihoVMuj8wneZIBeb1H0KC8RdWCBsNBQso7E
                        LxlH4nHWEf8afH6Bscc+wTijH2NcIGf0v1h3/KuMM/4zxhF/knXGnj0DyiBoEKm8McIFEkQZASAP
                        JX6i8EeGxE1vsHZ/+GEccGSrO/gf4qTzYhsBZRR6likQ1+lIL8zvrQZkaVBGL/KRAVgH9TCfAWUU
                        5k5GT7JUZ76yDg89TI4MQ11D8LsJKB8chnIjUGYEAByEIRYIxwdHYH4ZkFcBygjJB8ceoIOMYOYL
                        FH5HIMb8yTh8tVQeZdSBCQD5yfvJIdABnFYHyWVQPjAFLwzTMH8KfleBMoVlHKFvBuqinmSE5Oag
                        LOhe6l0+tBPqBO3HUfi2A4DDJ8YrryePMoIyanY31APatxt+V4EyQvPsnlNUFKCbgPLsvhNkP3be
                        q9K+smahHokOfehFxtjlvfApQPIZUEYgxg58sweOVzzJ9aC85wAA9kEoV9ahWuHQ1VKgjELP8t4j
                        woh9K4HynqOLZM8clIHPalDeDdozD/NBuxGO1wHKOwGUd+kA1vVQH3qSEZJXCcplD/Iu+KSQLIIy
                        ik43ofC3NCSXtdOcJ7utBZrtAoWAvAOBGDv31QFyRdAuowcZM11gxot6UEbhwCMoCsnWRkCu1g5o
                        y1HbEYhbgDJqh0vQjEsaklEzboBzDwo9zFXCTn2ipEB5BqB4xpegQjgug3IZljEMA9UsPRwVzMNR
                        +mh8MnbmC8PvZgONlCUFySgJUJ4MhWmnPhzCeioqdOKrFk7DMIxJmF8DyRKgjPHLUwkA7Dj8BiBu
                        Bco4Ot9kCsrB50qgjB7nyQzUh97kKlBGTWQDVONlSF4HKFOhZxlguNyZjwq+C/mTy6qC5DpQRmH8
                        MgLzxCKA9xLmX4bp6DUuQ3ITUB4FEB5bdJFRkCQog0YXnWRs+YxGy8IOfaLq8yhTIAahZxlVgWQR
                        lAVYBgAGCMbPVqBMJXbgQ2DGTBcYp1zpvFevMiiDhgGWh++t0umyhM58qPOWR7neeG3qMqWp8IQS
                        484AlFFq6wLhzbnHtxnSrxaLNTUc9Y63ZNrWE6PMupOjrDM+vMUdeaVY3Vk11pS5BDTMWTIpxpj6
                        ImvO/Jg1pZ5VuxZIhx8A2rdM1RGAT/8yUbryhLUlnuDsqcdh+z/J2pIx+L6z3RZXsPb41Zwr9lYc
                        qAUzboirqDFMbaewxYYUtuhRxhH9Au8DGBdBmYVGkQsAkEODyHijVFw4SZTxLGFCsRLr871KrKZi
                        bCB8c7s/pBN/njfbKChTIRA30wqgXIHjapWhWEp1oFwPx9Uqg/IZAQCj6uG4WiuAMgozXtSoGozr
                        JYLyfgDlGtVBchmUqeoAuUYVQC4LgLgJKOPw1VTiyHwUjOslBckoCUhGlUFZEEArqgqUG9QElPfu
                        bdSesuoAuaIKHFcLAFcE5WYqg/JuAOUalaFYSnWgXKMVQFlSZSiW0hpBuVYAwKsE5R1lOK6WCMpn
                        BNC7AijvMAkqZ72okRQko8pgXK8qUC6LQvIKoDxjLwsAeAVQnnEACIOkALkihGgqgNpqleG4WlWg
                        jJoqqwqSGyQFyGUhRFcJPclUUoBclhQko5qAMqoekGuEXmYqANsWoFwjAOJWoFwrAN0WoEyVLKsW
                        lCUlBcmoFUAZhcNW16gCySgA3xagXCOA4nIe5ZVAeaQIMIySAOSKFgCEqzRcViXTRbUAgqtAWVIi
                        KCMcV0sSkMvClHDVkgLksqpAGTVYLQBnQQDA1ZIC5LIkALmsTQVlNEabttG0aiIoozrdxwmrTy2K
                        RZoaQiJnTGrWkvUC4RFAc0LhSParvMk3i1WdU2vL5f54mzX9etacvpoxJLYx5mw3Y0mMcyDenhpm
                        LSkVbPPtrDX+rnZ/6mXiYmsyTCWnsGNnvcQpzp38PQcNJguQzPkAkD0xonBHv814Yk+jN5n1A0D7
                        I4QNxIgmXQBYjv5veyB6sVhVta0pJd3ZMBmU6ySDsiAJSEbJoAySQVkGZRmUZVAGKJZB+TkKyluO
                        ZP+RNWS/gSEXZVDmoQHDuF5WlxoTi0la27z3hQpzup81pYZXBcqOxAhjS4wDLN+xxRr8R7GaC94U
                        B5Nv5C35NoUxvV/pKmZYe+o2cVZTY83xN7Hu1H9hzDLnEeKUlYEMYbyJ3zOeeFThiPQyzpiZ8cY+
                        xYUShI+kCeMTM1vg4CKh6ONbPaFLxOouGJNBuU4yKAuSgGSUDMogGZRlUJZBWQZlgGIZlJ+joIzG
                        6lNbaMgFNGYUlo0ZorIWCW8t/pbVpt8nFmuwTmP2xQjGqwFl1h4fY23xAd6VupiscbCO82mcMfsG
                        Tp/9Kb44dPpPEA4aZM4Se6s4W9LabbFrAI6/qg4WCesUOvKpAjnCepLfAzjWMe6YGoexVjhjSt4e
                        fQnjj97FBhNf5sPJM2ngEJbD0a9sC4VWDIE5lyaDcp1kUBYkAckoGZRBMijLoCyDsgzKAMUyKD+H
                        QRmN0SbjnW4AQRGUUZh/mDfnvsrOxxtiZtF6vMt/xZoyXSuGXtgS46wj3sFapeu5kI3TZe7GIb/h
                        OBCNe4kw5uSj4ixJwxEGeX/6N+pwniAkY9YLVSBLGGf8vwCMt3POpAbLsK7omMIWroSeKHyRpApj
                        lEVQRmmyBfgM3oOhImKx824yKNdJBmVBEpCMkkEZJIOyDMoyKMugDFAsg/JzHJQ5feylnD7zNRz6
                        uZJ3GISZIjhT5n7pTmvkBQpD8ga2RR5lgOMx+OS3+LMvFhd6Thmny83SfNMmeHHwLBOFORkTZ9UY
                        HL+/Zt0JryqUp3mTWVeMYAc+3pMiAMz3YEy2wpXsanfGh1lPfELpTl6By2FnRjYQX6ahF9DYISCz
                        QeGTCUWJOp0jikBogK7kAjAZlOskg7IgCUhGyaAMkkFZBmUZlGVQBiiWQfk5DsporDZ9rdJSfFJp
                        LZ6BZQDETs8xwhiTEbFYjbHm7JtYU3pUYUwPNYCyjcYkdzKu5KYMJnI+jNFmCwIoZ4navUgYc+Kg
                        OKti28zRf+NcyQ91RBcq8cgIzADOv2HsiSD1pjuSvQDLQ4wrMcm641fT5Vyh9wEkf0mdLAIYxygo
                        Ywo4OrgIheUw/E4RRTD8gzs9nn+iKzvPJoNynWRQFiQBySgZlEEyKMugLIOyDMoAxTIo/wGAMppC
                        m9zV4TpGO/SVQZmHhqvDvURYU/KoWKximCKNs6SHFKB6UGatyQnGmrxULPocNPICVpf9pAaH+4bj
                        oXaWCGNK8+JMatss0Vs4T/o7mvACBWTMbqGJlhCYP83a4jsoJNviA5jtg3EmpuCl4Tq6nDvcyYdS
                        v1DFskJ6uFCC4FDVCn84zwQiUwyAMhsGeIbGTJ3JkfZA6DBd4Xk2GZTrJIOyIAlIRsmgDJJBWQZl
                        GZRlUAYolkH5DwSUL5qd/SNOn0x1ek5UQBlHs1NackTtWiQKY2K7WJJahzbwt6wx2VvToY96k1Po
                        Te6+DeaLRZ9z1jafeyGrzXxFjSMYQqOOg5TAi0GlcyNCMO/LPoUj88F3GmqhCRdx9L3IFmvw39st
                        KVW7PT5MIdkOkGxNvP9Sr/dPOX/MrIxmCR9OEYU3QpSRNOGjKcIGotpyPHK7L7SAYRcIynw8SRTB
                        0ON8NPoSuuLzaDIo10kGZUESkIySQRkkg7IMyjIoy6AMUCyD8h8KKIPREe2MmY9hPuUyKKN4a56o
                        HEXCGuOVtHGYL5ixpBkMv6gGZdaanmDMiSvFYs9J4+dzr+G02e+pzCWiNOcAklNPM/ZEZZhp1h5/
                        sCOySCEZYZn3pJ5l3fHdOA+hGI7jhMKWHMK80bwn+27O5nutwpe4V50oCbmTfVGiiucJF0z8ot0f
                        VdFKRWsPBt/JRhJPshEoB42XMglQ7Q9qxNnnzWRQrpMMyoIkIBklgzJIBmUZlGVQlkEZoFgG5T8g
                        UEZj9IV/5s25L2tcGJ8rgDLAMOHteaJ0FACWk9Ni0YtYY+pOxpIdL4My+//bu/OYOco6gOMvSohG
                        PKIBr8QTI2hEEI/EqlXReBEN5n3p7jMze4GFHti3LS1QWpbytrZv6fvuPbM7e8197Lvv0QtKgRZa
                        UJR4RoNXTPBKBeuBBClgH59nju27++5MWxDpC79v8sm+3Zndd7Z/NL9Onp3JWddGM/qSwZw9b66V
                        3C9ms/0BZqv9eGx8EseybUw+2+PRrP4+b/MAKmoH6CXg6LILrmz9iQzEzvWV6SXfyH7Lo1l1Bb12
                        NJNVP3YFL3+BrWq/TahTzq2rEfkHj65NZuv6T6NC1fliX2+RamN/qkX+Y9KU8ZWT5HWNxpz10f/v
                        Rq66bzL/7V/ibdc85Fri+0GX0aUhln0/2PJeD7qudW3tZ8X3gg33WPndQFtW9XrAtTrEdb7751rj
                        2txr7aFg1/sOdrthrk2+G+8Ltq7Xva6b5hrxrfcdmGtDgJv393VrerZ7XLeE2Oi7u9utc230jdzV
                        36Z+9rk2B7tli29vt60hRu8Its2V3nZ7t9tCbN8TbMx1c8du13gfmV67XNlgG3K+nXPle+1wFUIU
                        XeuLM3OVAvDT/Qlz3SRMucohKr7JbmI/bce6aoiab6JbvY+Gr+W40dcMIdvBlG43KJZLDaGZ/en9
                        GI7rjRCmT+9mhbA1x9p+Wr1U10SItk9xrJkMMSX3N91P0zXjuq7Xjtka3XaG2FV3rO61u5+aa0+I
                        26tdVvnu6Ed07Q2xz1fpsvKuEHeXu90TYr/QZXi2Az6+270h7isFWnGwV9F1qIiHHyjhVQ+W6dDM
                        eGPN8wtta10Uy038Ocnv6AzKTMYdluPkHy1mXB+h+zE5+wNo3Lyuc0aZXi4uZy6mA6PzRvM0tKV1
                        CTtqH42NtXE8R/5zkDEfW5Qx3+VtHmCK2nevtu7EbNm8f/al3ujZZJTV1hLXkOH5I9GStIKrGU8k
                        pBZGZRmzNR0ntAn65b2poWLzLd7L5rSo1ryUVbQjcd3CjCT/OiJJF3qbXrRGrjy0dcviB385ctWh
                        nzq+5btvjlsXB7k32NUBrnFt7GfpgWDLeizfH+iWa3vdc2IrfHfNNRxkX7CVAVbNdbNv9Z3B1vTa
                        61ob4nrfHSfvhv42rPPtOe6mEOup3cSubhu6rZ/t5p2n7pZgN3XMdNsY4tYQI651I9PdNoX4zlSw
                        La4bOiaDbe3Vdo0Gu/42X2uu7b3s48YCjIfIBLFO2tqM6cqFyPv0boVga4oheJ/aTeij7FMcq09G
                        RQ4mdlvlq4WoN4M1+lvZPBmNbnKYumO4H6VXzaWG0H3iiZmV/qx+yi7bteJUtEK0Bce1/Uz24l1T
                        IaaLwWZ6FU5spy/fZXmYXbluu4k9Ae7IdFl2MvaGuLO/pdS+XuMdS+7O/GzZ3dmfL9uX+ZI31jz/
                        0DZrARmW/5LkZzqDsjMs51s4Qb/gl7X4dDp9JjNufC263btMnLP0whhmi/Z53tvMyyKbjI8yW+2n
                        Zw3Kj6Ji+53eZrpG+S6W12y6VMV7yrlbobtGW0tEx/SPMxVViDdtHKuRvzdBxjHJdgZlVFM2DuCB
                        E954ZVGpegEjSV+/nOfP9Z56UcMD+IyFC9NnptP4FS996RdRv+OZz07lM/X+XcwH/T7H89HvdwAA
                        gAcHONG2F1q/3/tcvRDvRwy1hl55MvPXKYW2SJ8hw/Jh+mU+f1Cm2JyNU+IuzObtGTSmfYjJGFH3
                        bDIZFLPG6mjevVbwfI3bMnExM2o/FRt3B2WUMY+gcf093uYzIjn5Yvro/tEtmtMXRrNWhAzRlzKC
                        dm9SmcSsqGGmrOCk0qZD8qMRQbrC2x2CIAiCIAia79Gzo2RYfoTedGP2sMzkLJwUd2IyGP+CGdOX
                        MuNGPJozl6C8sRLlza94L5+XJUbb72O32UfimUnMZSfI5zWORsaND3qb50TPBEWyxoWRghrnqubv
                        EtIkZgQFsxUVp9QpzNWM7w8Wyp0vA0IQBEEQBEEvkRZlzAu4XOsnqcouuuTCHZSzlIHjAhkE8/YT
                        ZGDWonnralQwrqF35FuYTp/pvXzeFdlsvJnZZj0S9y4PxxXamM2Zn/Q29w2VlBtZ0Xwq3mi5d+er
                        GjgpkyG7rGpcoTCv12xDEARBEARBITGb1LeS4XgvHZbp0gt/UKa4QgvH+DZmcubPyMC8MZrTmdnr
                        d+db6fSBM7lR+yf0hiPOnfnoFxgzRsrb3BX94iIZhvVEY9K5njIdkumwzIn6s2xFW+vtBkEQBEEQ
                        BL2Ui6ebr2JzVjZemsLx0mRnUHbkTRwXyLBYbP2TyRvKYK4+vy8Rt9Wedm5hPWZhuuwkmjGL3qZO
                        9MoWLK//OElvYS1ozh366N35uKr5B8TLl3m7QRAEQRAEQS+X6NlVLj/xt2SFXv3CG5RzLjIok4G5
                        jZmC9QDKavN2WERbrRtTxV3OoEy/zIgy+kND6dZZ3uYBelk4VNKOdG5hXdZxig7MFf3gYKb2fm83
                        CIIgCIIg6OUWymgXsQX7UErc6QzH/qDsMnFCnMYcb2OU16dQXlvgvWzehEa1z8XG28e4TAuzOfr5
                        rKdRTr/E2zwwOCa9nSmph2PVFo6JZJhuTGDEK+WhYvFsbxcIgiAIgiDo5drgmP1qLmuOsHnraFKc
                        cZZfdIblvIHZoomT1RnM5vVnmYLeYgrqZ72XnvYNFVtnM9vM3yQK7qXx6NlzNqdlvc1O0ZK69Cp9
                        D+YqxlGW177tPQ1BEARBEARBbmhcW8AVWgcT4g7vS33uoMzkdQdXtHCyRgbmIh2ejTtZ3oqkRmuv
                        9V5+2sZuNzMpYbczKMdKE/SzHBnKyu/wNg8MtVpnMbwqLirAemQIgiAIgiAooKF0+iw2b6zkivaf
                        UtWdmONbnUHZUdAxWzJxojaN42Kb/Kz/ijx/W1zQFsSbzVd5b3NaxY5ZH+Yyrae4PBmSs4Yz7DMF
                        VfQ2QxAEQRAEQdDJx+aVd6OcUWILxpN0sORKdmdQ9tEzy3FxAicb02Rg1o6xvP5DVFI2o7L1ucWV
                        1uu9tzotYrYbeqqy2xmU2aKFuXLrPygvf9PbDEEQBEEQBEGnViRnXIwKusoUjH8nazswJ5CBedaw
                        zBQ1B8uTobnaxvTqEaxgYFRUH2F5zWB4eQ1X0hdezivnvhA3L4k3m29AYvMiVK0vZmS1iRpyg1WU
                        13ibO8W36+ezudY/YsU2Gfg1Z8Bny8ajkULto94uEARBEARBEHTq0WsNo7xWZQvG31L1GRyvtJ0v
                        +fmDckeJDM1kUI6JNhmap3CiSW8DrWHEq39leOV+pqzXokV1A+JljuUbn48UpQ8ONZtvGRyrvnFp
                        sXU2e5vyGh+98sQ3yCA8WK+fw1aV86J1+VOoogwtqknXoVqzQOyNVqXfo7r8dEw1cdJu41R7Gkfr
                        zbp32F1FxozhpLgDk8/gDMuJOvkMFf33TKnyMW8XCIIgCIIgCHpuxXLme1FRW8+WzJ/Hyi1n2UWs
                        bNO1yp1B+TjVGZLptYnp3e7ijQmcUqZxkojVLLJNwUxZeQoJyuOMIB9Ggvwb4mFUVh5GgkQem7+K
                        VuQ/IlH+B/EkEqVjbFPHcX0CJ802ebQxJ5Pf2yC/py5jVJfIzzJOGDZ5lEa9Qz4exmcwWd1K1XeS
                        Y6XHq5JBfgJzNeMxVJaRtxcEQRAEQRAEPfcGx8ZeHROMy1leV8nA+ViCLrugQ7NIhmbBOD4o87MI
                        x7FlMkBXNMxVyRBdNcjgbOJY3cJc02diTiKaBmYbOmbr5P3q5LUEqikYVSXy2IMMyhQrKTjZamPU
                        lGVWUc71Dtkpnmm+AeW0g6nmDvcYybAea1g4Jlk4WpXqqdrpfxUPCIIgCIIgaJ4UKdTexpb0GCuY
                        Khk+/8iVTZySZpylDTHRdM4oMzwdSruHZe+MchdU8ckYiT2qs/nDsYyZhkKGYw3HNHf5RUzVMWpI
                        T7CK+tCiRuOT3mF2YnnlXLao76fHyFbIsQnkPcggfuXENI7WGuu83SAIgiAIgiDof9dgtfpGTtC/
                        yhTV7zAl9R6mpDxGl18kpSln2UWiSQbZuo25qok5Ucesg55dVh1IdDEiGZyrRI38TNAzyvTMMicZ
                        OKZYOK7ZOGm5yy/owBytNv5OhuMHyeBcYBqNOF3TPNRqvdI7rDkxOfV1DK83neNpWGTwVsigPEPf
                        R/F2gSAIgiAIgqAXrsFc/RwyNF/K8PIwV9YKSFD3MrzyMHGEEeQniWfpoByrmzjetHFcnsAJlQyv
                        ku0sh6DDMR2YoxXpGVSV/4VE6TDxIyQ2ppmGsj1aaSxnxcbnGVV963O5qgZTUa9ma/rhhD6Jmab2
                        F6ahftrbBEEQBEEQBEH/35xbZhfkN3El+QIkaAsQL18WEaQoEpQro2VlSaQsDyNeWhwtS8mIKF0R
                        KTe/HCnXP8GKyrvpGmN6Jz3vrf4nscXqeWRAjkcrlfO9pyAIgiAIgiAIgiAIejE6duzY644ePXrh
                        M88880Xy82XE1+gj+fMX6PPkZ/hyMQRBUN8GBv4LZK7QlUNgD6cAAAAASUVORK5CYII=';
    }

    public static function envioCorreoConsentimiento
    ($paciente,$numDocumento,$ciudad,$ceulular,$correoDestino,$firma ,$fechaFirma)
    {

        $pdf = new Dompdf();
        $pdfRevocacion = new Dompdf();

        $html = '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Formulario de Consentimiento Informado</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                }
                h1 {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .container {
                    max-width: 800px;
                    margin: 0 auto;
                    padding: 20px;
                    position: relative;
                }
                .logo {
                    position: absolute;
                    top: 40px;
                    left: 40px;
                    width: 180px; /* Ajusta el ancho según tus necesidades */
                    height: auto; /* El alto se ajustará automáticamente según el ancho */
                }
                p {
                    margin-bottom: 10px;
                }
                ul {
                    margin-bottom: 10px;
                }
                .declaration {
                    margin-top: 30px;
                }
                .row {
                    display: flex; /* Utilizamos flexbox para crear una fila */
                }
                .column {
                    padding: 10px; /* Espacio entre las columnas */
                }

                .column1 {
                    flex: 1; /* Columna 1 será el doble de ancha que la columna 2 */
                }

                .column2 {
                    flex: 4; /* Columna 2 ocupará la tercera parte del espacio */
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="column column1">
                        <img alt="" alt="Logo" class="logo"
                        src="'.self::getlogo().'">
                    </div>
                    <div class="column column2">

                    </div>
                </div>
                <!-- Sección de formulario de consentimiento informado -->
                <h3>FORMULARIO DE CONSENTIMIENTO INFORMADO</h3>
                <p>YO, <strong>'.$paciente.'</strong>
                Identificado con CC # <strong>'.$numDocumento.'</strong>, residente en la ciudad de <strong>'.$ciudad.'</strong> y
                con el número de teléfono celular <strong>'.$ceulular.'</strong>, reconozco que he leído, entendido y
                aceptado participar en el estudio: Plataforma Clínico-Genómica Integrada para la Investigación Biomédica en Colombia,
                 según se define en este documento. He leído la siguiente información:</p>

                <!-- Lista de elementos del formulario de consentimiento informado -->
                <ul>
                    <li>He podido hacer preguntas sobre el proceso y me las han aclarado. De acuerdo.</li>
                    <li>Entiendo que la participación en este proyecto es voluntaria y altruista. De acuerdo.</li>
                    <li>Entiendo cómo puedo retirar mi participación en este estudio. De acuerdo.</li>
                    <li>Entiendo que mis datos genéticos, respuestas a encuestas de salud, datos clínicos y cualquier otro dato no identificable, pueden ser utilizados para futuras investigaciones relacionadas con cualquier enfermedad humana. De acuerdo.</li>
                    <li>Entiendo que Healthylink research y/o Galatea Bio pueden volver a ponerse en contacto conmigo en el futuro (por ejemplo, para responder a preguntas de salud adicionales o para ser invitado a participar en evaluaciones posteriores) (opcional). De acuerdo.</li>
                    <li>He leído el consentimiento informado y doy mi permiso al equipo de investigación y a sus colaboradores para realizar las pruebas de laboratorio descritas, incluida la secuenciación y otras pruebas de muestra.</li>
                    <li>Entiendo y acepto que mis muestras, datos de pruebas e información clínica pueden ser utilizados, sin la información que me identifica directamente, para futuras investigaciones, educación y fines asociados de Galatea Bio, Healthylink Research y sus colaboradores académicos y comerciales, incluida la investigación y el desarrollo de productos médicos.</li>
                    <li>Entiendo que esto puede implicar que Galatea Bio y Healthylink Research comparta mis muestras, datos de pruebas e información clínica con terceros, incluidos colaboradores académicos y comerciales, que pueden estar fuera del país, con el fin de desarrollar este estudio u otros afines.</li>
                    <li>Entiendo que no compartiré ninguna ganancia comercial si la investigación conduce a productos médicos o de otro tipo.</li>
                    <li>Entiendo que puede haber un riesgo para la privacidad de mis datos, pero en este estudio se asignará un código único a mis muestras, pruebas e información clínica antes de cualquier uso en la investigación. Mi nombre u otra información identificable no se usará ni se vinculará con mi muestra e información clínica cuando se comparta con terceros, a menos que autorice explícitamente dicha divulgación.</li>
                    <li>Entiendo que los miembros del equipo de investigación pueden ponerse en contacto conmigo más adelante con respecto a mi interés en participar en otras actividades de investigación, incluida la contribución de información clínica adicional o muestras para su uso en dichas actividades o la autorización del uso de mi información de identificación para usos de investigación.</li>

                </ul>

                <!-- Declaraciones adicionales -->
                <div class="declaration">
                    <p>Por todo lo anterior, consiento en:</p>
                    <ul>
                        <li>El personal investigador podrá utilizar las muestras donadas y mis datos para las condiciones establecidas en este consentimiento.</li>
                        <li>Mi información no identificable podrá ser utilizada por otras entidades nacionales e internacionales para las condiciones establecidas en este consentimiento</li>
                    </ul>
                </div>
                <p><strong>Nombre completo:</strong>'.$paciente.'</p>
                <p><strong>CC #:</strong> '.$numDocumento.'</p>
                <p><strong>Fecha de la firma:</strong> '.$fechaFirma.'</p>
                <p><strong>Firma:</strong></p>
                <img height="20%" width="40%" src="'.$firma.'">
            </div>
        </body>
        </html>';

        $htmlRevocacion = '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Revocacion de consentimiento informado</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                }
                h1 {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .container {
                    max-width: 800px;
                    margin: 0 auto;
                    padding: 20px;
                    position: relative;
                }
                .logo {
                    position: absolute;
                    top: 40px;
                    left: 40px;
                    width: 180px; /* Ajusta el ancho según tus necesidades */
                    height: auto; /* El alto se ajustará automáticamente según el ancho */
                }
                p {
                    margin-bottom: 10px;
                }
                ul {
                    margin-bottom: 10px;
                }
                .declaration {
                    margin-top: 30px;
                }
                .row {
                    display: flex; /* Utilizamos flexbox para crear una fila */
                }
                .column {
                    padding: 10px; /* Espacio entre las columnas */
                }

                .column1 {
                    flex: 1; /* Columna 1 será el doble de ancha que la columna 2 */
                }

                .column2 {
                    flex: 4; /* Columna 2 ocupará la tercera parte del espacio */
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="column column1">
                        <img alt="" alt="Logo" class="logo"
                        src="'.self::getlogo().'">
                    </div>
                    <div class="column column2">

                    </div>
                </div>
                <!-- Sección de formulario de consentimiento informado -->
                <h3>REVOCACION DE CONSENTIMIENTO INFORMADO</h3>
                <p>Yo, ________________________________ identificado con _____________________ retiro libre
                y conscientemente el consentimiento otorgado en la fecha ___________________ para la realización
                 del estudio: Una Plataforma Clínico-Genómica Integrada para la Investigación Biomédica en Colombia,
                 y declaro que a partir de la fecha ___________________________ las muestras que he donado,
                 y que estén disponibles, y mi información sea retirada de la base de datos.:</p>


                <p><strong>Firma:</strong></p>
                <p><strong>Número de documento del participante:</strong></p>
            </div>
        </body>
        </html>';

        $pdf->loadHtml($html);
        $pdf->setPaper('letter', 'portrait');
        $pdf->render();
        $pdfContent = $pdf->output();

        $pdfRevocacion->loadHtml($htmlRevocacion);
        $pdfRevocacion->setPaper('letter', 'portrait');
        $pdfRevocacion->render();
        $pdfContentRevocacion = $pdfRevocacion->output();

        $mail = new PHPMailer(true);

        try {
            // Configurar el servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'jose.barrios@mibcode.com';//env('MAIL_USERNAME');//
            $mail->Password = 'Katya0506*';//'env('MAIL_PASSWORD');//';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;//env('MAIL_PORT'); //587;

            // Configurar el remitente y el destinatario
            $mail->setFrom(/*env('MAIL_FROM_ADDRESS)'*/'jose.barrios@mibcode.com', 'HEALTHYLINK RESEARCH S.A.S');
            $mail->addAddress($correoDestino);

            // Adjuntar el archivo al correo electrónico
            $fileName = $numDocumento.'.pdf';
            $fileNameRevocacion = 'Revocacion de consentimiento.pdf';


            $mail->addStringAttachment($pdfContent, $fileName);
            $mail->addStringAttachment($pdfContentRevocacion, $fileNameRevocacion);

            $mail->addBCC('josebarriosp15@gmail.com');
            $mail->addBCC('legal@hlinkresearch.com');

            // Configurar el asunto y el cuerpo del correo electrónico
            $mail->isHTML(true);
            $mail->Subject = 'Una Plataforma Clinico-Genomica Integrada para la Investigacion Biomedica en Colombia.';
            $mail->Body = 'Estimado (a) '.$paciente.',

            Espero que este mensaje le encuentre bien. <br>

            Queremos expresar nuestro más sincero agradecimiento por su participación en el proyecto de investigación Plataforma Clínica Genómica. Adjunto a este correo electrónico, encontrará el documento del consentimiento informado que previamente ha sido firmado durante su involucramiento en nuestro proyecto. Este documento contiene detalles completos sobre el proyecto, incluyendo toda la información que fue previamente explicada y que es relevante para su participación.

            Además, hemos incluido un formulario de revocación de consentimiento que le brinda la opción de retirarse del proyecto en cualquier momento, si así lo desea.

            Su confianza en nuestro equipo y en este proyecto de investigación es invaluable. Si tiene alguna pregunta adicional o necesita más información, no dude en ponerse en contacto con nosotros.

            Agradecemos enormemente su tiempo y dedicación. <br>

            Quedamos a su disposición para cualquier consulta que pueda surgir.';

            // Enviar el correo electrónico
            $mail->send();

            return true;
        } catch (Exception $e) {
            return "Error al enviar el correo electrónico: {$mail->ErrorInfo}";
        }
    }

    public static function enviarTokenMFA($token,$correo)
    {
        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'legal@hlinkresearch.com';//env('MAIL_USERNAME');//
            $mail->Password = 'legalprocedures';//'env('MAIL_PASSWORD');//';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;//env('MAIL_PORT'); //587;


            $mail->setFrom(/*env('MAIL_FROM_ADDRESS)'*/'legal@hlinkresearch.com', 'HEALTHYLINK RESEARCH S.A.S');
            $mail->addAddress($correo);

            //$mail->addBCC('josebarriosp15@gmail.com');


            $mail->isHTML(true);
            $mail->Subject = 'CODIGO DE ACCESO - HEALTHYLINK APP.';
            $mail->Body = 'Estimado Usuario su codigo de ingreso A la plataforma es: '.$token;

            $mail->send();

            return true;
        } catch (Exception $e) {
            return "Error al enviar el correo electrónico: {$mail->ErrorInfo}";
        }
    }
}
