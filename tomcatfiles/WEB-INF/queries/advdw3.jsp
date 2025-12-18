<%@ page session="true" contentType="text/html; charset=ISO-8859-1" %>
<%@ taglib uri="http://www.tonbeller.com/jpivot" prefix="jp" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jstl/core" %>

<jp:mondrianQuery id="query01"
    jdbcDriver="com.mysql.jdbc.Driver"
    jdbcUrl="jdbc:mysql://localhost:3306/advuas1?user=root&password=" catalogUri="/WEB-INF/queries/advdw.xml">

select {[Measures].[Amount], [Measures].[TotalQuantity]} ON COLUMNS,
{( [Customer], [Time])} ON ROWS
from [Jual]

</jp:mondrianQuery>

<c:set var="title01" scope="session">OLAP AdventureWorks</c:set>
