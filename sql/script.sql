CREATE TABLE Felhasznalo (
    nev VARCHAR2(255) UNIQUE NOT NULL,
    email VARCHAR2(255) PRIMARY KEY,
    jelszo VARCHAR2(255) NOT NULL,
    szerepkor VARCHAR2(1) DEFAULT 'u' NOT NULL, /*user, admin*/
    szuletesi_datum DATE,
    profil_kep_utvonal VARCHAR2(300)
);

CREATE TABLE Uzenet (
    uzenet_id NUMBER GENERATED ALWAYS as IDENTITY(START with 1 INCREMENT by 1) PRIMARY KEY,
    tartalom VARCHAR2(1024) NOT NULL,
    ido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    cimzett VARCHAR2(255) NOT NULL,
    email VARCHAR2(255) NOT NULL,
    FOREIGN KEY (cimzett) REFERENCES Felhasznalo(email)
    ON DELETE CASCADE,
    FOREIGN KEY (email) REFERENCES Felhasznalo(email)
    ON DELETE CASCADE
);

CREATE TABLE Ismeretseg (
    email1 VARCHAR2(255),
    email2 VARCHAR2(255),
    allapot VARCHAR2(1) CHECK (allapot IN ('p', 'a')), /* pending, accepted*/
    PRIMARY KEY (email1, email2),
    FOREIGN KEY (email1) REFERENCES Felhasznalo(email)
    ON DELETE CASCADE,
    FOREIGN KEY (email2) REFERENCES Felhasznalo(email)
    ON DELETE CASCADE
);

CREATE TABLE TiltottSzavak(
    szo VARCHAR(255) PRIMARY KEY,
    email VARCHAR(255) REFERENCES Felhasznalo(email)
    ON DELETE CASCADE
);


INSERT ALL
INTO Felhasznalo(nev, email, jelszo, szerepkor, szuletesi_datum)
VALUES ('Teszt Elek', 'tesztelek@gmail.com', '$2y$10$UHWO9PndRFn5hR.AEIifSeip93zqqBGzWqUmUXnZIseyQNqjvHf4S'/*tesztelek*/, 'u', TO_DATE('2042-12-25', 'yyyy-mm-dd'))
INTO Felhasznalo(nev, email, jelszo, szerepkor, szuletesi_datum)
VALUES('Matyi az Igazságtalan', 'matyi@gmail.com', '$2y$10$oN20DPpjtRXPWVyba0mkBeXFOdMr4W5187bwIqj29hyFPNQ4qmvW.'/*matyi*/, 'u', TO_DATE('1526-08-29', 'yyyy-mm-dd'))
INTO Felhasznalo(nev, email, jelszo, szerepkor, szuletesi_datum)
VALUES('Buszmegállomás', 'ikarusz@gmail.com', '$2y$10$f7CJAFiiWsS/t5URUub6ge3amwldb3G322I5ubWqMD17QziHcpYCi'/*ikarusz*/, 'u', TO_DATE('2025-03-27', 'yyyy-mm-dd'))
INTO Felhasznalo(nev, email, jelszo, szerepkor, szuletesi_datum)
VALUES('LEGO Batman', 'legobatman2@gmail.com', '$2y$10$STVrcCXPmyRUre9kvoyvKur3WS0yc9CQ2tf3tqhMChbnzqaHkw1SC'/*legodiluc*/, 'a', TO_DATE('2012-06-19', 'yyyy-mm-dd'))
INTO Felhasznalo(nev, email, jelszo, szerepkor, szuletesi_datum)
VALUES('Gregor Samsa', 'gregorsamsa@gmail.com', '$2y$10$zH4s4fYctciC2di8DQ2CC.QZPoCBwnVRw6f5NBBnxmuKomO2/6z3m'/*cockroach*/, 'u', TO_DATE('1915-10-10', 'yyyy-mm-dd'))
INTO Felhasznalo(nev, email, jelszo, szerepkor, szuletesi_datum)
VALUES ('Teszt Elek2', 'tesztelek2@gmail.com', '$2y$10$UHWO9PndRFn5hR.AEIifSeip93zqqBGzWqUmUXnZIseyQNqjvHf4S'/*tesztelek*/, 'u', TO_DATE('2042-12-25', 'yyyy-mm-dd'))
INTO Felhasznalo(nev, email, jelszo, szerepkor, szuletesi_datum)
VALUES ('Teszt Elek3', 'tesztelek3@gmail.com', '$2y$10$UHWO9PndRFn5hR.AEIifSeip93zqqBGzWqUmUXnZIseyQNqjvHf4S'/*tesztelek*/, 'u', TO_DATE('2042-12-25', 'yyyy-mm-dd'))
INTO Felhasznalo(nev, email, jelszo, szerepkor, szuletesi_datum)
VALUES ('Teszt Elek4', 'tesztelek4@gmail.com', '$2y$10$UHWO9PndRFn5hR.AEIifSeip93zqqBGzWqUmUXnZIseyQNqjvHf4S'/*tesztelek*/, 'u', TO_DATE('2042-12-25', 'yyyy-mm-dd'))
INTO Felhasznalo(nev, email, jelszo, szerepkor, szuletesi_datum)
VALUES ('Teszt Elek5', 'tesztelek5@gmail.com', '$2y$10$UHWO9PndRFn5hR.AEIifSeip93zqqBGzWqUmUXnZIseyQNqjvHf4S'/*tesztelek*/, 'u', TO_DATE('2042-12-25', 'yyyy-mm-dd'))
INTO Felhasznalo(nev, email, jelszo, szerepkor, szuletesi_datum)
VALUES ('Teszt Elek6', 'tesztelek6@gmail.com', '$2y$10$UHWO9PndRFn5hR.AEIifSeip93zqqBGzWqUmUXnZIseyQNqjvHf4S'/*tesztelek*/, 'u', TO_DATE('2042-12-25', 'yyyy-mm-dd'))
INTO Felhasznalo(nev, email, jelszo, szerepkor, szuletesi_datum)
VALUES ('Teszt Elek7', 'tesztelek7@gmail.com', '$2y$10$UHWO9PndRFn5hR.AEIifSeip93zqqBGzWqUmUXnZIseyQNqjvHf4S'/*tesztelek*/, 'u', TO_DATE('2042-12-25', 'yyyy-mm-dd'))
INTO Felhasznalo(nev, email, jelszo, szerepkor, szuletesi_datum)
VALUES ('Teszt Elek8', 'tesztelek8@gmail.com', '$2y$10$UHWO9PndRFn5hR.AEIifSeip93zqqBGzWqUmUXnZIseyQNqjvHf4S'/*tesztelek*/, 'u', TO_DATE('2042-12-25', 'yyyy-mm-dd'))
INTO Felhasznalo(nev, email, jelszo, szerepkor, szuletesi_datum)
VALUES ('Teszt Elek9', 'tesztelek9@gmail.com', '$2y$10$UHWO9PndRFn5hR.AEIifSeip93zqqBGzWqUmUXnZIseyQNqjvHf4S'/*tesztelek*/, 'u', TO_DATE('2042-12-25', 'yyyy-mm-dd'))
INTO Felhasznalo(nev, email, jelszo, szerepkor, szuletesi_datum)
VALUES ('Teszt Elek10', 'tesztelek10@gmail.com', '$2y$10$UHWO9PndRFn5hR.AEIifSeip93zqqBGzWqUmUXnZIseyQNqjvHf4S'/*tesztelek*/, 'u', TO_DATE('2042-12-25', 'yyyy-mm-dd'))
SELECT 1 FROM DUAL;

INSERT INTO Uzenet (tartalom, cimzett, email)
VALUES ('Its over, Anakin! I have the high ground!', 'matyi@gmail.com', 'tesztelek@gmail.com');
INSERT INTO Uzenet (tartalom, cimzett, email)
VALUES('You underestimate my power!', 'tesztelek@gmail.com', 'matyi@gmail.com');
INSERT INTO Uzenet (tartalom, cimzett, email)
VALUES('Dont try it!', 'matyi@gmail.com', 'tesztelek@gmail.com');
INSERT INTO Uzenet (tartalom, cimzett, email)
VALUES('Remember, When Youre Lost in The Darkness Look for the Light!', 'legobatman2@gmail.com', 'gregorsamsa@gmail.com');
INSERT INTO Uzenet (tartalom, cimzett, email)
VALUES('Believe in the Fireflies!', 'legobatman2@gmail.com', 'gregorsamsa@gmail.com');

INSERT INTO Ismeretseg (email1, email2, allapot)
VALUES('legobatman2@gmail.com', 'ikarusz@gmail.com', 'p');
INSERT INTO Ismeretseg (email1, email2, allapot)
VALUES('matyi@gmail.com', 'tesztelek@gmail.com', 'a');
INSERT INTO Ismeretseg (email1, email2, allapot)
VALUES('ikarusz@gmail.com', 'tesztelek@gmail.com', 'a');
INSERT INTO Ismeretseg (email1, email2, allapot)
VALUES('tesztelek@gmail.com', 'gregorsamsa@gmail.com', 'p');
INSERT INTO Ismeretseg (email1, email2, allapot)
VALUES('matyi@gmail.com', 'gregorsamsa@gmail.com', 'a');
INSERT INTO Ismeretseg (email1, email2, allapot)
VALUES ('legobatman2@gmail.com', 'gregorsamsa@gmail.com', 'a');
INSERT INTO Ismeretseg (email1, email2, allapot)
VALUES ('tesztelek2@gmail.com', 'legobatman2@gmail.com', 'p');
INSERT INTO Ismeretseg (email1, email2, allapot)
VALUES ('tesztelek3@gmail.com', 'legobatman2@gmail.com', 'p');
INSERT INTO Ismeretseg (email1, email2, allapot)
VALUES ('legobatman2@gmail.com', 'tesztelek4@gmail.com', 'a');
INSERT INTO Ismeretseg (email1, email2, allapot)
VALUES ('legobatman2@gmail.com', 'tesztelek10@gmail.com', 'a');

INSERT ALL
INTO TiltottSzavak (szo, email) VALUES('nemszepszo', 'legobatman2@gmail.com')
INTO TiltottSzavak (szo, email) VALUES('csunya', 'legobatman2@gmail.com')
INTO TiltottSzavak (szo, email) VALUES('ronda', 'legobatman2@gmail.com')
INTO TiltottSzavak (szo, email) VALUES('windows', 'legobatman2@gmail.com')
INTO TiltottSzavak (szo, email) VALUES('java', 'legobatman2@gmail.com')
SELECT 1 FROM DUAL;




CREATE OR REPLACE TYPE Ismeros AS OBJECT (
    email VARCHAR2(255),
    nev   VARCHAR2(255)
);
/
CREATE OR REPLACE TYPE IsmerosIsmeroseiReturn AS TABLE OF Ismeros;
/

CREATE OR REPLACE FUNCTION ismerosok_ismerosei (
    arg_felhasznalo_email IN VARCHAR2
) RETURN IsmerosIsmeroseiReturn PIPELINED
IS
BEGIN
    FOR r IN (
        WITH FelhasznaloKapcsolatai AS (
            SELECT CASE 
                       WHEN email1 = arg_felhasznalo_email THEN email2 
                       ELSE email1 
                   END AS kapcsolt_email
            FROM Ismeretseg
            WHERE (email1 = arg_felhasznalo_email OR email2 = arg_felhasznalo_email)
        ),
        ElfogadottIsmerosok AS (
            SELECT kapcsolt_email
            FROM FelhasznaloKapcsolatai kapcsolat
            JOIN Ismeretseg ismeretseg
              ON (ismeretseg.email1 = arg_felhasznalo_email AND ismeretseg.email2 = kapcsolat.kapcsolt_email)
              OR (ismeretseg.email2 = arg_felhasznalo_email AND ismeretseg.email1 = kapcsolat.kapcsolt_email)
            WHERE ismeretseg.allapot = 'a'
        ),
        IsmerosokIsmerosei AS (
            SELECT CASE 
                       WHEN ismerosek_kozotti.email1 = ismeros.kapcsolt_email THEN ismerosek_kozotti.email2
                       ELSE ismerosek_kozotti.email1
                   END AS jelolt_email
            FROM Ismeretseg ismerosek_kozotti
            JOIN ElfogadottIsmerosok ismeros
              ON (ismerosek_kozotti.email1 = ismeros.kapcsolt_email OR ismerosek_kozotti.email2 = ismeros.kapcsolt_email)
            WHERE ismerosek_kozotti.allapot = 'a'
        )
        SELECT DISTINCT felhasznalo.email, felhasznalo.nev
        FROM IsmerosokIsmerosei ajanlott
        JOIN Felhasznalo felhasznalo ON felhasznalo.email = ajanlott.jelolt_email
        WHERE felhasznalo.email != arg_felhasznalo_email
          AND felhasznalo.email NOT IN (
              SELECT kapcsolt_email FROM FelhasznaloKapcsolatai
          )
    ) LOOP
        PIPE ROW(Ismeros(r.email, r.nev));
    END LOOP;

    RETURN;
END;
/

CREATE OR REPLACE TRIGGER tiltott_szo_felhasznalonev
BEFORE INSERT OR UPDATE ON Felhasznalo
FOR EACH ROW
DECLARE
    szavak_szama INT := 0;
BEGIN
    SELECT COUNT(*)
    INTO szavak_szama
    FROM TiltottSzavak
    WHERE LOWER(:NEW.nev) LIKE '%' || LOWER(szo) || '%';
    IF szavak_szama = 1 THEN
        RAISE_APPLICATION_ERROR(-20777, 'A felhasználónév tiltott szót tartalmaz!');
    ELSIF szavak_szama >1 THEN
        RAISE_APPLICATION_ERROR(-20778, 'A felhasználónév számos tiltott szót tartalmaz!');
    END IF;
END;
/


