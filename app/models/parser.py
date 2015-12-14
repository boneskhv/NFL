import urllib.request
import sqlite3
import datetime

def ParseStanding():
    response = urllib.request.urlopen('http://espn.go.com/nfl/standings')
    html = response.read()
    response.close

    print(html)

    bd = sqlite3.connect("../app/models/NFL.db")
    #bd = sqlite3.connect("NFL.db")

    bd.execute("drop table if exists standings")
    bd.commit()

    bd.execute('CREATE TABLE standings(team, pct, pf, pa)')
    bd.commit()
    bd.close()

    from bs4 import BeautifulSoup
    soup = BeautifulSoup(html,'html.parser')

    #find tout les nom de team
    links = soup.find_all('span',class_='team-names')
    i = 0
    for link in links:
        names = link.contents[0]
        #fulllink = link.get('')

        if(names.string != None):
            print(names.string)
            #print(fulllink)

            #find tout les scores pour chaque team
            #links2 = soup.find_all('td',class_='')
            links2 = soup.findAll('tr')[i].find_all('td')
            BDStanding(names, links2[4].contents[0], links2[9].contents[0], links2[10].contents[0])
            for link2 in links2:
                stat = link2.contents[0]


                if(stat.string != None):
                    print(stat.string)

        #indice pour trouver le score associer avec la bonne team
        i = i + 1
        print('\n')

    #BD()


def BDStanding(team, pct, pf, pa):
    bd = sqlite3.connect("../app/models/NFL.db")
    #bd = sqlite3.connect("NFL.db")

    bd.execute("INSERT INTO standings VALUES (?,?,?,?)",(team, pct, pf, pa))
    bd.commit()
    bd.close()




def ParseScore():
    bd = sqlite3.connect("../app/models/NFL.db")
    #bd = sqlite3.connect("NFL.db")

    bd.execute("drop table if exists scores")
    bd.commit()

    bd.execute('CREATE TABLE scores(score)')
    bd.commit()

    week = datetime.date.today().isocalendar()[1] - datetime.date(2015,9,3).isocalendar()[1]

    for i in range(1, week -1):
        response = urllib.request.urlopen('http://espn.go.com/nfl/schedule/_/week/' + str(i))
        print('http://espn.go.com/nfl/schedule/_/week/' + str(i))
        html = response.read()
        response.close

        print(html)



        from bs4 import BeautifulSoup
        soup = BeautifulSoup(html,'html.parser')

        rows = soup.find_all("tr")
        for row in rows:
            dataCol = 0
            cols = row.find_all("td")
            for col in cols:
                a = col.find_all("a")
                #print(a[0].contents[0])
                if(dataCol == 2):
                    #test = a[0].contents[0]
                    #print(test)
                    BDScore(a[0].contents[0])
                if(dataCol == 5):
                    dataCol = 0
                else:
                    dataCol = dataCol +1
                '''
                for team in a:
                    names = team.contents[0]
                    #print(team[0])
                '''

        print('\n')

    bd.close()


def BDScore(score):
    bd = sqlite3.connect("../app/models/NFL.db")
    #bd = sqlite3.connect("NFL.db")

    print(score)
    bd.execute("INSERT INTO scores VALUES (?)",(score,))
    bd.commit()
    bd.close()


def ParseFutur():
    bd = sqlite3.connect("../app/models/NFL.db")
    #bd = sqlite3.connect("NFL.db")

    bd.execute("drop table if exists futures")
    bd.commit()

    bd.execute('CREATE TABLE futures(home, visitor, location, id)')
    bd.commit()

    week = datetime.date.today().isocalendar()[1] - datetime.date(2015,9,3).isocalendar()[1]
    id = 0

    for i in range(week, 18):
        response = urllib.request.urlopen('http://espn.go.com/nfl/schedule/_/week/' + str(i))
        print('http://espn.go.com/nfl/schedule/_/week/' + str(i))
        html = response.read()
        response.close

        from bs4 import BeautifulSoup
        soup = BeautifulSoup(html,'html.parser')

        team1 = ""
        team2 = ""
        loc = ""
        rows = soup.find_all("tr")
        for row in rows:
            cols = row.find_all("td")
            if(cols != []):
                odd = True
                for col in cols:
                    if(col.contents[0].string != None):
                        1 + 1
                        loc = col.contents[0].string

                    a = col.find_all("a", class_="team-name")

                    for team in a:
                        if(odd == True):
                            team1 = team.contents[0].string
                            odd = False
                            id = id + 1
                        else:
                            team2 = team.contents[0].string
                            odd = True


                BDFutur(team1, team2, loc, id)
        print('\n')

    bd.close()

def BDFutur(home, visitor, location, id):
    bd = sqlite3.connect("../app/models/NFL.db")
    #bd = sqlite3.connect("NFL.db")

    print(home, visitor, location)
    bd.execute("INSERT INTO futures VALUES (?,?,?, ?)",(home,visitor,location, id))
    bd.commit()
    bd.close()

ParseFutur()
ParseScore()
ParseStanding()

'''
            for col in cols:
                a = col.find_all("a")
                print(col.contents[1].contents[0].string)

                #print(a[0].contents[0])
                if(dataCol == 2):
                    print(a[0].contents[0])
                    #BDScore(a[0].contents[0])
                if(dataCol == 3):
                    dataCol = 0
                else:
                    dataCol = dataCol +1


                for team in a:
                    names = team.contents[0]
                    #print(team.contents[0].string)
                '''