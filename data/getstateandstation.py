# -*- coding: utf-8 -*-
"""
Created on Sun Mar 29 13:14:23 2015

@author: yilin
"""

import re
file = open("dropdowndata.txt")
writer = open("stateandstationdata.txt",'w')
writer2 = open("statesdata.txt",'w')

statepre="None"
for line in file:
    line=line.strip()
    id,name,latitude,longitude,locality,state,country=line.split("\t")
    id = id[0:-1]
    name = name[1:-1]
    locality = locality[1:-1]
    state = state[1:-1]
    country = country[1:]
    
    if country == "United States":
        countryandstate = state
    else:
        countryandstate = str(country) + "-" + str(state)
    if state<>statepre:
        if statepre<>"None":
            writer.write("];" +'\n')
        writer.write("stationArr['" + countryandstate + "'] = [" +'\n')
        writer2.write("\t" + '<option value="' + countryandstate + '">' + countryandstate + "</option>" +'\n')
    writer.write("\t" + "{txt:'" + str(name) + "', val:'" + str(id) + "'}," +'\n')
    statepre = state
writer.write("];" +'\n')
file.close()
writer.close()
writer2.close()